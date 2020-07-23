<?php
// phpcs:disable
namespace App;

use App\Utils\CanBeRated;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CanBeRated;

    protected $guarded = [];
    protected $primary_key = 'id';
    protected $table = 'products';

    public function category ()
    {
        return $this->belongsTo(Category::class);
    }
}
