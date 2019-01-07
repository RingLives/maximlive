<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpStore extends Model
{
    protected $table = 'mxp_store';
    protected $fillable = [
    			'user_id',
    			'job_id',
    			'booking_order_id',
    			'erp_code',
    			'item_code',
    			'item_size',
    			'item_quantity',
    			'is_type',
    			'product_id',
    			'status',
    			'is_deleted',
    			'deleted_user_id',
    			'deleted_date_at',
    			'last_action_at',
    			'receive_date',
    			'shipment_date'
			];
}
