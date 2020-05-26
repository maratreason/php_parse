<?php
  include ('libs/SQL.php');
  include ('libs/phpQuery-onefile.php');
  include ('libs/simple_html_dom.php');

  $sql = SQL::getInstance();
  $banks = [];

  function get_content($url, $sql) {
    $html = file_get_contents($url);
    $dom = str_get_html($html);

    $allBanks = $dom->find('.filter_container > div');

    foreach($allBanks as $bank) {
      $toDatabase = array();

      $link = find_tag_name($bank, 'a', 0);

      $shortHref = explode('/head-offices', $link->href)[1];

      $one = file_get_contents($url . $shortHref);
      $one_dom = str_get_html($one);

      $field = find_tag_name($one_dom, '.bcard__contact', 0);

      $toDatabase['name'] = $one_dom->find('.heading_border', 0)->plaintext;
      $toDatabase['address'] = $field->find('li span')[0]->plaintext;
      $toDatabase['phone'] = $field->find('li span')[1]->plaintext;
      $toDatabase['hope_phone'] = $field->find('li span')[2]->plaintext;
      $toDatabase['no_license'] = $field->find('li span')[3]->plaintext;
      $toDatabase['identify_num'] = $field->find('li span')[4]->plaintext;
      $toDatabase['email'] = $field->find('li span')[5]->plaintext;
      $toDatabase['site'] = $field->find('li span')[6]->plaintext;

      $sql->insert('banks', $toDatabase);
    }
  }

  /**
   * Функция поиска элеменотов по тэгам.
   */
  function find_tag_name($domElement, $tagName, $position) {
    return $domElement->find($tagName, $position);
  }
?>
