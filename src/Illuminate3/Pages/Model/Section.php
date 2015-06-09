<?php

namespace Illuminate3\Pages\Model;

class Section extends \Eloquent
{
	const MODE_PUBLIC 		= 'public';
	const MODE_PROTECTED 	= 'protected';

    protected $table = 'sections';

    public $timestamps = false;

    public $rules = array();

    protected $guarded = array('id');

    protected $fillable = array(
        'title',
        'name',
		'mode'
        );

	/**
	 * @return bool
	 */
	public function isPublic()
	{
		return $this->mode == self::MODE_PUBLIC;
	}

	/**
	 * @return bool
	 */
	public function isProtected()
	{
		return $this->mode == self::MODE_PROTECTED;
	}


}

