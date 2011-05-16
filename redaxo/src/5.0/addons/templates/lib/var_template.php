<?php

/**
 * REX_TEMPLATE[2]
 *
 * @package redaxo5
 * @version svn:$Id$
 */

class rex_var_template extends rex_var
{
  // --------------------------------- Output

  public function getBEOutput(rex_sql $sql, $content)
  {
    return $this->matchTemplate($content);
  }

  public function getTemplate($content)
  {
    return $this->matchTemplate($content);
  }

  /**
   * Wert für die Ausgabe
   */
  private function matchTemplate($content)
  {
    $var = 'REX_TEMPLATE';
    $matches = $this->getVarParams($content, $var);

    foreach ($matches as $match)
    {
      list ($param_str, $args) = $match;
      $template_id = $this->getArg('id', $args, 0);

      if($template_id > 0)
      {
        $varname = '$__rex_tpl'. $template_id;
        $tpl = '<?php
        '. $varname .' = new rex_template('. $template_id .');
        require rex_stream::factory("template/'. $template_id .'", '. $this->handleGlobalVarParamsSerialized($var, $args, '$this->replaceCommonVars('. $varname .'->getTemplate(), '. $template_id .')') .');
        ?>';
	      $content = str_replace($var . '[' . $param_str . ']', $tpl, $content);
      }
    }

    return $content;
  }
}