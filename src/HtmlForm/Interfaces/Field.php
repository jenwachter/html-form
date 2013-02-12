<?php

namespace HtmlForm\Interfaces;

interface Field
{
	public function compileLabel();
	public function compileAttributes();
	public function compile($value);
}