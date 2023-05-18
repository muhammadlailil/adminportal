<?php
namespace Laililmahfud\Adminportal\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasUuid;
use Laililmahfud\Adminportal\Models\CmsAdmin;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use \Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CmsNotification extends Model
{
    use HasFactory,HasUuid,HasDatatable;

    protected $table = 'cms_notifications';
    protected $fillable = ['title', 'admin_id','description','is_read','url_detail'];

    public function admin()
    {
        return $this->belongsTo(CmsAdmin::class, 'admin_id', 'id');
    }

      /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function urlDetail(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (str_contains($value,'http:://') || str_contains($value,'https:://'))?$value:url($value),
        );
    }


    private static $title;
    private static $description;
    private static $receivers = [];
    private static $url_detail;
    public static function setTitle($title){
        self::$title = $title;
        return new static();
    }

    public static function setDescription($description){
        self::$description = $description;
        return new static();
    }

    public static function setReceivers($receivers){
        self::$receivers = $receivers;
        return new static();
    }

    public static function setUrlDetail($url_detail){
        self::$url_detail = $url_detail;
        return new static();
    }

    public static function send(){
        /**
         *  CmsNotification::setReceivers(['98302bac-db67-4751-8335-3e5598bf0a57','98302bac-db67-4751-8335-3e5598bf0a57'])
         * ->setTitle('Pelanggan Baru')
         * ->setDescription('Pelanggan baru melakukan registrasi')
         * ->setUrlDetail('/admin/faq')
         * ->send();
         */
        if(self::$title && self::$description && count(self::$receivers) && self::$url_detail){
            $insert = collect(self::$receivers)->map(function($id){
                return [
                    'id' => Str::uuid()->toString(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'title' => self::$title,
                    'description' => self::$description,
                    'admin_id' => $id,
                    'url_detail' => self::$url_detail,
                    'is_read' => 0
                ];
            })->toArray();
            
            CmsNotification::insert($insert);
        }
    }

}
