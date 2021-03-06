<?php
/**
 * @filesource Widgets/Textlink/Controllers/Write.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Widgets\Textlink\Controllers;

use \Kotchasan\Http\Request;
use \Gcms\Login;
use \Kotchasan\Html;
use \Kotchasan\Language;

/**
 * เขียน-แก้ไข
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Write extends \Gcms\Controller
{

  /**
   * แสดงผล
   *
   * @param Request $request
   * @return string
   */
  public function render(Request $request)
  {
    if (defined('MAIN_INIT')) {
      // ข้อความ title bar
      $this->title = Language::trans('{LNG_Create or Edit} {LNG_Text links}');
      // เมนู
      $this->menu = 'widget';
      // สามารถตั้งค่าระบบได้
      if (Login::checkPermission(Login::adminAccess(), 'can_config')) {
        // รายการที่ต้องการ
        $index = \Widgets\Textlink\Models\Index::getById($request->request('id')->toInt(), $request->request('_name')->topic());
        if ($index) {
          // แสดงผล
          $section = Html::create('section');
          // breadcrumbs
          $breadcrumbs = $section->add('div', array(
            'class' => 'breadcrumbs'
          ));
          $ul = $breadcrumbs->add('ul');
          $ul->appendChild('<li><span class="icon-widgets">{LNG_Widgets}</span></li>');
          $ul->appendChild('<li><span>{LNG_Text links}</span></li>');
          $ul->appendChild('<li><span>{LNG_'.(empty($index->id) ? 'Create' : 'Edit').'}</span></li>');
          $section->add('header', array(
            'innerHTML' => '<h2 class="icon-ads">'.$this->title().'</h2>'
          ));
          // แสดงฟอร์ม
          $section->appendChild(createClass('Widgets\Textlink\Views\Write')->render($index));
          return $section->render();
        }
      }
    }
    // 404.html
    return \Index\Error\Controller::page404();
  }
}
