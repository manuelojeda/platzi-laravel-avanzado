<?php
// phpcs:disable
namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    protected $primary_key = 'id';
    protected $table = 'products';
}
