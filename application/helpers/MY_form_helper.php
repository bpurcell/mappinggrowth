<?php


function form_boot_input($data = '', $value = '', $extra = '')
{
	$defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);
	return "<div class=\"controls\"><input "._parse_form_attributes($data, $defaults).$extra." /></div>";
}

function form_hidden($name, $value = '', $recursing = FALSE)
{
	static $form;

	if ($recursing === FALSE)
	{
		$form = "\n";
	}

	if (is_array($name))
	{
		foreach ($name as $key => $val)
		{
			form_hidden($key, $val, TRUE);
		}
		return $form;
	}

	if ( ! is_array($value))
	{
		$form .= '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.form_prep($value, $name).'" />'."\n";
	}
	else
	{
		foreach ($value as $k => $v)
		{
			$k = (is_int($k)) ? '' : $k;
			form_hidden($name.'['.$k.']', $v, TRUE);
		}
	}

	return $form;
}