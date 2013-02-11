<?php

namespace HtmlForm\Interfaces;

interface Field
{
	public function compileLabel($field);
	public function compileAttributes($field);
	public function compile($field);
}