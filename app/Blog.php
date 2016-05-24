<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $guarded = array();

    protected $appends = [ // Eloquent magic
        'tagged',
        'starred',
        'text',
        'image',
        'images',
        'time_ago'
    ];
    // protected $hidden = ['user', 'category', 'tags', 'ratings'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function tag()
    {
        return $this->hasMany('\App\Tag');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function user()
    {
        return $this->belongsTo('\App\Models\Access\User\User');
    }

    public function stars()
    {
        return $this->hasMany('Star');
    }
    public function tags()
    {
        return $this->belongsToMany('\App\Tag');
    }
    public function tagz()
    {
        $tagz= [];
        foreach ($this->tags as $key => $tag) {
            $tagz[$tag['name']] = $tag['name'];
        };
        return $tagz;
    }
    public function getTaggedAttribute()
    {
        return $this->tags ? $this->tags()->lists('name') : null;
    }
    public function getStarredAttribute()
    {
        return count($this->stars);
    }
    public function getImageAttribute()
    {
        $user = User::find($this->id);
        // preg_match_all('/<img[^>]+>/i', $this->body, $images);
        preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $this->body, $image);
        //$image[0] contains the full IMG tag, and $image[1] contains the source URI 

        if (isset($image[1])):
            $img = $image[1];
            // return $img;
            // return $img[0][0];
            // return var_dump($img[0]);
        elseif ($user):
            $user_image = $user->image;
        $img = $user_image; else:
            $img = '/assets/img/world.png';
        endif;
        
        return $img;
    }
    public function getImagesAttribute()
    {
        preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $this->body, $images);
        return $images[1];
    }
    public function getTextAttribute()
    {
        // return strip_tags($this->body);
        // return html_entity_decode($this->body);
        return strip_tags(html_entity_decode($this->body));
    }
    public function getTimeAgoAttribute()
    {
        $time = $this->created_at;

        if ($time->diffInSeconds() > 60) {
            if ($time->diffInMinutes() > 60) {
                if ($time->diffInHours() > 24) {
                    return $time->format('d M Y');
                }
                return $time->diffInHours().' hours ago';
            }
            return $time->diffInMinutes().' mins ago';
        }
        return $time->diffInSeconds().' secs ago';
    }
    public function getAuthorImage()
    {
        if ($user = $this->user):
            $user_image = $user->image;
        $img = $user_image ? $user_image : '/assets/img/favicon.png'; else:
            $img = '/assets/img/favicon.png';
        endif;
        
        return $img;
    }

    //Send GCM push notification
    public function gcm($reg_ids)
    {
        $message = [
                'title' => $this->title,
                'business_name' => $this->user->name,
                // 'business_logo' => $this->user->image,
                'id' => $this->id,
            ];
        // $message = [$this->title];
        // return $message;
        return Article::gcmPush($reg_ids, $message);
    }
        
    public static function gcmPush($reg_ids, $message)
    {
        //Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $reg_ids,
            'data' => ['m'=>$message],
        );
        // Update your Google Cloud Messaging API Key
        define("GOOGLE_API_KEY", Config::get('app.gcm'));
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}
