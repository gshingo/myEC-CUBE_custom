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
require_once CLASS_REALDIR . 'pages/frontparts/bloc/LC_Page_FrontParts_Bloc_Category.php';

/**
 * カテゴリ のページクラス(拡張).
 *
 * LC_Page_FrontParts_Bloc_Category をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id: LC_Page_FrontParts_Bloc_Category_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class LC_Page_FrontParts_Bloc_Category_Ex extends LC_Page_FrontParts_Bloc_Category {

    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    function process() {
        parent::process();
    }

    /**
     * デストラクタ.
     *
     * @return void
     */
    function destroy() {
        parent::destroy();
    }

    /**
     * カテゴリツリーの取得.
     *
     * @param array $arrParentCategoryId 親カテゴリの配列
     * @param boolean $count_check 登録商品数をチェックする場合はtrue
     * @return array $arrRet カテゴリツリーの配列を返す
     */
    function lfGetCatTree($arrParentCategoryId, $count_check = false) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objDb = new SC_Helper_DB_Ex();
        $col = '*';
        $from = 'dtb_category left join dtb_category_total_count ON dtb_category.category_id = dtb_category_total_count.category_id';
        // 登録商品数のチェック
        if ($count_check) {
            $where = 'del_flg = 0 AND product_count > 0';
        } else {
            $where = 'del_flg = 0';
        }
        $objQuery->setOption('ORDER BY rank DESC');
        $arrRet = $objQuery->select($col, $from, $where);
        $arrRetShashu = $arrRet; // 車種別のカテゴリに表示するリスト
        $arrRetGyohmu = $arrRet; // 業務別のカテゴリに表示するリスト
        $arrRetDriver = $arrRet; // ドライバー用品別のカテゴリに表示するリスト
        $arrRetGaisoh = $arrRet; // 外装別のカテゴリに表示するリスト
        $arrRetDenshoku = $arrRet; // 電飾別のカテゴリに表示するリスト
        $arrRetNaisoh = $arrRet; // 内装インテリア別のカテゴリに表示するリスト
        /**
         *  $arrRet[idx][0](category_id)        = 登録されてる自分のID
         *  $arrRet[idx][1](category_name)      = 登録名
         *  $arrRet[idx][2](parent_category_id) = 親のID(最上位の場合は0が入る)
         *  $arrRet[idx][3](level)              = 階層の深さ(ＴＯＰが1、以下2,3,4となる)
         *  
         *  1.$arrRet[idx][2]が０の物のリストAを作る、$arrRet[idx][0]を使用。
         *  2.リストAが親のＩＤとしているされている物のリスト
         */
        $SHASHU_ID   =  7;
        $GYOHMU_ID   =  8;
        $DRIVER_ID   =  9;
        $GAISOH_ID   = 10;
        $DENSHOKU_ID = 11;
        $NAISOH_ID   = 12;
        foreach ($arrParentCategoryId as $category_id) {
            $arrParentID = $objDb->sfGetParents(
                'dtb_category',
                'parent_category_id',
                'category_id',
                $category_id
            );
            $arrBrothersID = SC_Utils_Ex::sfGetBrothersArray(
                $arrRet,
                'parent_category_id',
                'category_id',
                $arrParentID
            );
            $arrChildrenID = SC_Utils_Ex::sfGetUnderChildrenArray(
                $arrRet,
                'parent_category_id',
                'category_id',
                $category_id
            );
            $this->root_parent_id[] = $arrParentID[0];
            $arrDispID = array_merge($arrBrothersID, $arrChildrenID);
            foreach ($arrRet as $key => $array) {
                foreach ($arrDispID as $val) {
                    if ($array['category_id'] == $val) {
                        $arrRet[$key]['display'] = 1;
                        break;
                    }
                }
            }

            // 車種別
            $this->lfSetCatName($SHASHU_ID, $arrRetShashu, $arrDispID);
            //foreach($arrRet_syasyu as $key => $array) {
            //    foreach($arrDispID as $val)
            //    {
            //        if($array['parent_category_id'] == $SYASYU_ID)
            //        {
            //            $arrRet_syasyu[$key]['display'] = 1;
            //            $arrRet_syasyu[$key]['category_name'] = htmlentities($arrRet_syasyu[$key]['category_name'], ENT_QUOTES, 'UTF-8');
            //            break;
            //        }
            //    }
            //}
            // 業務用品別
            $this->lfSetCatName($GYOHMU_ID, $arrRetGyohmu, $arrDispID);
            // ドライバー用品別
            $this->lfSetCatName($DRIVER_ID, $arrRetDriver, $arrDispID);
            // 外装
            $this->lfSetCatName($GAISOH_ID, $arrRetGaisoh, $arrDispID);
            // 電飾別
            $this->lfSetCatName($DENSHOKU_ID, $arrRetDenshoku, $arrDispID);
            // 内装インテリア別
            $this->lfSetCatName($NAISOH_ID, $arrRetNaisoh, $arrDispID);
        }
/*
        $arrRet['shashu'] = $arrRetShashu;
        $arrRet['gyohmu'] = $arrRetGyohmu;
        $arrRet['driver'] = $arrRetDriver;
        $arrRet['gaisoh'] = $arrRetGaisoh;
        $arrRet['denshoku'] = $arrRetDenshoku;
        $arrRet['naisoh'] = $arrRetNaisoh;
*/
        $this->arrRet_syasyu = $arrRetShashu;
        $this->arrRet_gyoumu = $arrRetGyohmu;
        $this->arrRet_driver = $arrRetDriver;
        $this->arrRet_gaisou = $arrRetGaisoh;
        $this->arrRet_densyoku = $arrRetDenshoku;
        $this->arrRet_naisou = $arrRetNaisoh;

        return $arrRet;
    }

    function lfSetCatName($type_id, &$arrType, $arrDispID) {
//        $arrTemp = $arrType;
//        $arrType = array();
//        foreach ($arrTemp as $key => $array) {
        foreach ($arrType as $key => $array) {
            foreach ($arrDispID as $val) {
                if ($array['parent_category_id'] == $type_id) {
                    $arrType[$key]['display'] = 1;
                    $arrType[$key]['category_name'] = htmlentities($array['category_name'], ENT_QUOTES, 'UTF-8');
//                    $arrType[$key]['category_id'] = $array['category_id'];
                    break;
                }
            }
        }
    }
}
