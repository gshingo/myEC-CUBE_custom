<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2012 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

// {{{ requires
require_once CLASS_REALDIR . 'util/SC_Utils.php';

/**
 * 各種ユーティリティクラス(拡張).
 *
 * SC_Utils をカスタマイズする場合はこのクラスを使用する.
 *
 * @package Util
 * @author LOCKON CO.,LTD.
 * @version $Id: SC_Utils_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class SC_Utils_Ex extends SC_Utils {

    /**
     * 税金額を返す
     *
     * ・店舗基本情報に基づいた計算は SC_Helper_DB::sfTax() を使用する
     *
     * @param integer $price 計算対象の金額
     * @param integer $tax 税率(%単位)
     *     XXX integer のみか不明
     * @param integer $tax_rule 端数処理
     * @return integer 税金額
     */
    function sfTax($price, $tax, $tax_rule) {
        $real_tax = $tax / 100;
        $ret = $price * $real_tax;
        switch ($tax_rule) {
            // 四捨五入
            case 1:
                //$ret = round($ret);
                $ret = round($ret, 1); // 小数点以下第二位を四捨五入
                $ret = round($ret);    // その後、整数にする為、四捨五入
                break;
            // 切り捨て
            case 2:
                $ret = floor($ret);
                break;
            // 切り上げ
            case 3:
                $ret = ceil($ret);
                break;
            // デフォルト:切り上げ
            default:
                $ret = ceil($ret);
                break;
        }
        return $ret;
    }

    function sfMergeCheckEventBoxes($array, $max) {
        $ret = "";
        if (is_array($array)) {
            foreach ($array as $val) {
                $arrTmp[$val] = "1";
            }
        }
        for ($i=0; $i<$max; $i++) {
            if (isset($arrTmp[$i]) && $arrTmp[$i] == "1") {
                $ret .= "1";
            } else {
                $ret .= "0";
            }
        }
        return $ret;
    }

    function sfSplitCheckEventBoxes($val) {
        $arrRet = array();
        $len = strlen($val);
        for ($i=0; $i<$len; $i++) {
            if (substr($val, $i, 1) == "1") {
                $arrRet[] = $i;
            }
        }
        return $arrRet;
    }

    // FIXME: Util に置くべき関数ではない
    /**
     * 商品詳細画面で、規格１のみしか設定してないのに規格２が表示されてしまう件の対応
     *
     * @return void
     */
     function chk_classcategory_id() {
         $objQuery =& SC_Query_Ex::getSingletonInstance();

         // 不正なデータを初期化
         $sqlval = array();
         $sqlval['classcategory_id2'] = '0';
         $where = "classcategory_id2 IN (SELECT classcategory_id FROM dtb_classcategory WHERE class_id = 0 AND rank = 0 AND creator_id = 0)";
         $objQuery->update("dtb_products_class", $sqlval, $where);

         // 非登録用のIDを生成する
         $sqlval = array();
         $sqlval['classcategory_id'] = '0';
         $where = "class_id = 0 AND rank = 0 AND creator_id = 0";
         $objQuery->update("dtb_classcategory", $sqlval, $where);
     }
}
