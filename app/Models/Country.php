<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public $timestamps = false;

    /**
     * The attribute types will be define here, it's required to return data to API in correct types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
    ];

    public static function get_country_name($id)
    {
        $country = self::select('name')->where('id', $id)->first();
        return @$country['name'];
    }

    public static function get_country($id, $column)
    {
        $country = self::where('id', $id)->first();
        return @$country[$column];
    }

    public function state()
    {
        return $this->hasMany(state::class);
    }
}
