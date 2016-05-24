<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uploader extends CI_Controller {
	
	/* Constructor */
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('jbimages','language'));
		
		// is_allowed is a helper function which is supposed to return False if upload operation is forbidden
		// [See jbimages/is_alllowed.php] 
		
		if (is_allowed() === FALSE)
		{
			exit;
		}
		// User configured settings
		$this->config->load('uploader_settings', TRUE);
		$this->config->load('aws', TRUE);

	}
	
	
	/* Language set */
	
	private function _lang_set($lang)
	{
		// We accept any language set as lang_id in **_dlg.js
		// Therefore an error will occur if language file doesn't exist
		
		$this->config->set_item('language', $lang);
		$this->lang->load('jbstrings', $lang);
	}
	
	/* Default upload routine */
		
	public function upload ($lang='english')
	{
		// Set language
		$this->_lang_set($lang);
		
		// Get configuartion data (we fill up 2 arrays - $config and $conf)
		
		$conf['img_path']			= $this->config->item('img_path',		'uploader_settings');
		$conf['allow_resize']		= $this->config->item('allow_resize',	'uploader_settings');
		
		$config['allowed_types']	= $this->config->item('allowed_types',	'uploader_settings');
		$config['max_size']			= $this->config->item('max_size',		'uploader_settings');
		$config['encrypt_name']		= $this->config->item('encrypt_name',	'uploader_settings');
		$config['overwrite']		= $this->config->item('overwrite',		'uploader_settings');
		$config['upload_path']		= $this->config->item('upload_path',	'uploader_settings');
		
		if (!$conf['allow_resize'])
		{
			$config['max_width']	= $this->config->item('max_width',		'uploader_settings');
			$config['max_height']	= $this->config->item('max_height',		'uploader_settings');
		}
		else
		{
			$conf['max_width']		= $this->config->item('max_width',		'uploader_settings');
			$conf['max_height']		= $this->config->item('max_height',		'uploader_settings');
			
			if ($conf['max_width'] == 0 and $conf['max_height'] == 0)
			{
				$conf['allow_resize'] = FALSE;
			}
		}
		
		// Load uploader
		$this->load->library('upload', $config);
		
		if ($this->upload->do_upload()) // Success
		{
			// General result data
			$result = $this->upload->data();
			
			// Shall we resize an image?
			if ($conf['allow_resize'] and $conf['max_width'] > 0 and $conf['max_height'] > 0 and (($result['image_width'] > $conf['max_width']) or ($result['image_height'] > $conf['max_height'])))
			{				
				// Resizing parameters
				$resizeParams = array
				(
					'source_image'	=> $result['full_path'],
					'new_image'		=> $result['full_path'],
					'width'			=> $conf['max_width'],
					'height'		=> $conf['max_height']
				);
				
				// Load resize library
				$this->load->library('image_lib', $resizeParams);
				
				// Do resize
				$this->image_lib->resize();
			}
			
			$result['result']		= "file_uploaded";
			$result['resultcode']	= 'ok';
			$result['file_name']	= $conf['img_path'] . '/' . $result['file_name'];
			$result['base_url'] 	= '';
			
			$s3Config = $this->config->item('s3', 'aws');
			if($s3Config['enable'] === true){
				$clientOptions = array(
					'key' => $s3Config['key'],
					'secret' => $s3Config['secret'],
				);
				$awsClient = Aws\S3\S3Client::factory($clientOptions);
				$awsUploader = new Justboilme\Upload\AwsUpload($awsClient, $s3Config);
				$result['base_url'] =   $s3Config['url'].'/'.$s3Config['bucket'];
				try{
					// $awsUploader->uploadFile(result['file_temp'],  $result['file_name']);
					$awsUploader->uploadFile($result['full_path'],  $result['file_name']);
					// $awsUploader->uploadFile('/Users/macbookair/Projects/NairobiIO/nairobi.io/public/uploads/users/image/1/1461051288.png',  $result['file_name']);

					file_put_contents($config['upload_path'].'/log.txt', date('Y-m-d H:i:s')."\n"
							.__CLASS__.'@'.__FUNCTION__.':'.__LINE__."\n"
							.$result['file_temp']."\n" // cant get original client file path
							.$config['img_path'].$result['file_name']."\n"
							.$result['full_path']."\n"
							.$result['base_url'].$result['file_name']."\n"
							."\n", FILE_APPEND | LOCK_EX);

					// $awsUploader->uploadFile($_FILES[$field]['tmp_name'],  $result['file_name']);
				}
				catch(Exception $e){
					$result['result']	= 'S3 Upload failed with message: '.$e->getMessage();
					$result['resultcode']	= 'failed';
					$result['file_name']	= '';
					$result['base_url'] 	=  '';   
				}			
			}
			// Output to user
			$this->load->view('ajax_upload_result', $result);
		}
		else // Failure
		{
			// Compile data for output
			$result['result']		= $this->upload->display_errors(' ', ' ');
			$result['resultcode']	= 'failed';
			$result['file_name']	 = '';
			$result['base_url']		= '';   
			// Output to user
			$this->load->view('ajax_upload_result', $result);
		}
	}
	
	/* Blank Page (default source for iframe) */
	
	public function blank($lang='english')
	{
		$this->_lang_set($lang);
		$this->load->view('blank');
	}
	
	public function index($lang='english')
	{
		$this->blank($lang);
	}
}

/* End of file uploader.php */
/* Location: ./application/controllers/uploader.php */
