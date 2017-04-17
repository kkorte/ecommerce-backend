<?php 

namespace Hideyo\Ecommerce\Backend\Models;

use Hideyo\Ecommerce\Backend\Models\BaseModel;

class Redirect extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */    
    protected $table = 'redirect';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['active', 'url', 'shop_id', 'redirect_url', 'clicks'];
}