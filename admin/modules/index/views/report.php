<?php
/**
 * @filesource modules/index/views/report.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Index\Report;

use \Kotchasan\Http\Request;
use \Kotchasan\DataTable;

/**
 * ฟอร์ม forgot
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\Adminview
{

  /**
   * แสดงข้อมูลประวัติการเยียมชม
   *
   * @param Request $request
   * @param string $ip
   * @param string $date
   * @return string
   */
  public function render(Request $request, $ip, $date)
  {
    // URL สำหรับส่งให้ตาราง
    $uri = $request->createUriWithGlobals(WEB_URL.'admin/index.php');
    // ตาราง
    $table = new DataTable(array(
      /* Uri */
      'uri' => $uri,
      /* ข้อมูล Array */
      'datas' => \Index\Report\Model::get($ip, $date),
      /* รายการต่อหน้า */
      'perPage' => $request->cookie('counter_perPage', 30)->toInt(),
      /* ส่วนหัวของตาราง และการเรียงลำดับ (thead) */
      'headers' => array(
        'time' => array(
          'text' => '{LNG_Time}',
          'sort' => 'time'
        ),
        'ip' => array(
          'text' => '{LNG_IP}',
          'sort' => 'ip'
        ),
        'count' => array(
          'text' => '{LNG_Count}',
          'class' => 'center',
          'sort' => 'count'
        ),
        'referer' => array(
          'text' => '{LNG_Referer}',
          'sort' => 'referer'
        ),
        'agent' => array(
          'text' => '{LNG_User Agent}',
          'class' => 'tablet',
          'sort' => 'agent'
        ),
      ),
      /* รูปแบบการแสดงผลของคอลัมน์ (tbody) */
      'cols' => array(
        'count' => array(
          'class' => 'center'
        ),
        'agent' => array(
          'class' => 'tablet'
        ),
      )
    ));
    // save cookie
    setcookie('counter_perPage', $table->perPage, time() + 3600 * 24 * 365, '/');
    // คืนค่า HTML
    return $table->render();
  }
}