<?php

namespace App\Utils;

use App\Events\ModelRated;
use Illuminate\Database\Eloquent\Model;

trait CanRate
{
  public function ratings($model = null): object
  {
    $modelClass = $model ? $model : $this->getMorphClass();

    $morphToMany = $this->morphToMany(
      $modelClass,
      'qualifier',
      'ratings',
      'qualifier_id',
      'rateable_id'
    );

    $morphToMany
      ->as('rating')
      ->withTimestamps()
      ->withPivot('rating', 'rateable_type')
      ->wherePivot('rateable_type', $model)
      ->wherePivot('qualifier_type', $this->getMorphClass());

    return $morphToMany;
  }

  public function rate(Model $model, float $score): bool
  {
    if ($this->hasRated($model)) {
      return false;
    }

    $this->ratings($model)
      ->attach($model->getKey(), [
        'rating' => $score,
        'rateable_type' => get_class($model)
      ]);

      event(new ModelRated($this, $model, $score));

    return true;
  }

  public function hasRated(Model $model): bool
  {
    return ! is_null($this->ratings($model->getMorphClass())->find($model->getKey()));
  }
}