<?php

namespace Illuminate3\Pages\Model;

class Page extends \Eloquent
{
    protected $table = 'pages';
    public $timestamps = false;
    public $rules = array(
        'title' => 'required',
        'route' => 'required',
    );
    protected $guarded = array('id');
    protected $fillable = array(
        'title',
        'route',
        'alias',
        'method',
        'layout_id',
        'controller',
    );

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function layout()
    {
        return $this->belongsTo('Illuminate3\Pages\Model\Layout');
    }


}

