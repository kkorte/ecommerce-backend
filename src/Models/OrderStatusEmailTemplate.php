<?php 

namespace Hideyo\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusEmailTemplate extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */    
    protected $table = 'order_status_email_template';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['title', 'subject', 'content', 'shop_id', 'modified_by_user_id'];

    public function __construct(array $attributes = array())
    {
        $this->table = config()->get('hideyo.db_prefix').$this->table;  
        parent::__construct($attributes);
    }
}