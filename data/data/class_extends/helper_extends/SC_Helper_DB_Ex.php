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
require_once CLASS_REALDIR . 'helper/SC_Helper_DB.php';

/**
 * DB関連のヘルパークラス(拡張).
 *
 * LC_Helper_DB をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Helper
 * @author LOCKON CO.,LTD.
 * @version $Id: SC_Helper_DB_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class SC_Helper_DB_Ex extends SC_Helper_DB {

    /**
     * 送料情報を取得する. // FIXME: どの配送方法の送料情報なのかが分からない
     *
     * 引数 $force が false の場合は, 初回のみ DB 接続し,
     * 2回目以降はキャッシュされた結果を使用する.
     *
     * @param boolean $force 強制的にDB取得するか
     * @param string $col 取得カラムを指定する
     * @return array 送料情報の配列
     */
    function sfGetDelivFeeData($force = false, $col = '') {
        static $data = array();

        if ($force || empty($data)) {
            $objQuery =& SC_Query_Ex::getSingletonInstance();
            $where = 'fee > 0';
            $objQuery->setOrder('deliv_id, pref');
            if ($col === '') {
                $arrRet = $objQuery->select('*', 'dtb_delivfee', $where);
            } else {
                $arrRet = $objQuery->select($col, 'dtb_delivfee', $where);
            }
            //if (isset($arrRet[0])) {
            //    $data = $arrRet[0];
            if (isset($arrRet)) {
                $data = $arrRet;
            } else {
                $data = array();
            }
        }
        return $data;
    }

    /**
     * 商品規格情報を取得する.
     *
     * @param array $arrID 規格ID
     * @return array 規格情報の配列
     */
    // README:下記のsfTotalCartでのみ使用. なので、再利用する.
    function sfGetProductsClass($arrID) {
        list($product_id, $classcategory_id1, $classcategory_id2) = $arrID;

        if($classcategory_id1 == "") {
            $classcategory_id1 = '0';
        }
        if($classcategory_id2 == "") {
            $classcategory_id2 = '0';
        }

        // 商品規格取得
        $objQuery =& SC_Query_Ex::getSingletonInstance();
/*
        $col = "product_id, deliv_fee, name, product_code, main_list_image, main_image, price01, price02, point_rate, product_class_id, classcategory_id1, classcategory_id2, class_id1, class_id2, stock, stock_unlimited, sale_limit, sale_unlimited";
        $table = "vw_product_class AS prdcls";
// CHANGE START
        //$where = "product_id = ? AND classcategory_id1 = ? AND classcategory_id2 = ? AND status = 1";
        $where = "product_id = ? AND classcategory_id1 = ? AND classcategory_id2 = ? AND( status = 1 OR option_item_flg = 1)";
// CHANGE END
*/
        $col = '*';
        $table = 'dtb_products_class AS t1 LEFT JOIN dtb_products USING(product_id)';
        $where = 't1.product_id = ? AND classcategory_id1 = ? AND classcategory_id2 = ? AND( status = 1 OR option_item_flg = 1)';
//        $objQuery->setorder("rank1 DESC, rank2 DESC");
        $arrRet = $objQuery->select($col, $table, $where, array($product_id, $classcategory_id1, $classcategory_id2));
        return $arrRet[0];
    }

    /**
     * カート内商品の集計処理を行う.
     *
     * @param LC_Page $objPage ページクラスのインスタンス
     * @param SC_CartSession $objCartSess カートセッションのインスタンス
     * @param array $arrInfo 商品情報の配列
     * @return LC_Page 集計処理後のページクラスインスタンス
     */
/* SC_CartSession_Ex 他に実装済み
    function sfTotalCart(&$objPage, $objCartSess, $arrInfo) {

        // 規格名一覧
        $arrClassName = $this->sfGetIDValueList("dtb_class", "class_id", "name");
        // 規格分類名一覧
        $arrClassCatName = $this->sfGetIDValueList("dtb_classcategory", "classcategory_id", "name");

        $objPage->tpl_total_pretax = 0;		// 費用合計(税込み)
        $objPage->tpl_total_tax = 0;		// 消費税合計
        if (USE_POINT === true) {
            $objPage->tpl_total_point = 0;		// ポイント合計
        }

        // カート内情報の取得
        $arrCart = $objCartSess->getCartList();
        $max = count($arrCart);
        $cnt = 0;

        for ($i = 0; $i < $max; $i++) {
            // 商品規格情報の取得
            $arrData = $this->sfGetProductsClass($arrCart[$i]['id']);

            $limit = "";
            // DBに存在する商品
            if (count($arrData) > 0) {

// DELETE START
//                // 購入制限数を求める。
//                if ($arrData['stock_unlimited'] != '1' && $arrData['sale_unlimited'] != '1') {
//                    if($arrData['sale_limit'] < $arrData['stock']) {
//                        $limit = $arrData['sale_limit'];
//                    } else {
//                        // 購入制限数を在庫数に
//                        #$limit = $arrData['stock'];
//                        // 購入制限数をSALE_LIMIT_MAXに
//                        $limit = SALE_LIMIT_MAX;
//                    }
//                } else {
//                    if ($arrData['sale_unlimited'] != '1') {
//                        $limit = $arrData['sale_limit'];
//                    }
//                    if ($arrData['stock_unlimited'] != '1') {
//                        // 購入制限数を在庫数に
//                        #$limit = $arrData['stock'];
//                        // 購入制限数をSALE_LIMIT_MAXに
//                        $limit = SALE_LIMIT_MAX;
//                    }
//                }
// DELETE END

                if($limit != "" && $limit < $arrCart[$i]['quantity']) {
                    // カート内商品数を制限に合わせる
                    $objCartSess->setProductValue($arrCart[$i]['id'], 'quantity', $limit);
                    $quantity = $limit;
                    $objPage->tpl_message = "※「" . $arrData['name'] . "」は販売制限しております、一度にこれ以上の購入はできません。";
                } else {
                    $quantity = $arrCart[$i]['quantity'];
                }

                $objPage->arrProductsClass[$cnt] = $arrData;
                $objPage->arrProductsClass[$cnt]['quantity'] = $quantity;
                $objPage->arrProductsClass[$cnt]['cart_no'] = $arrCart[$i]['cart_no'];
                $objPage->arrProductsClass[$cnt]['class_name1'] =
                isset($arrClassName[$arrData['class_id1']])
                ? $arrClassName[$arrData['class_id1']] : "";

                $objPage->arrProductsClass[$cnt]['class_name2'] =
                isset($arrClassName[$arrData['class_id2']])
                ? $arrClassName[$arrData['class_id2']] : "";

                $objPage->arrProductsClass[$cnt]['classcategory_name1'] =
                $arrClassCatName[$arrData['classcategory_id1']];

                $objPage->arrProductsClass[$cnt]['classcategory_name2'] =
                $arrClassCatName[$arrData['classcategory_id2']];
                

                // 画像サイズ
                $main_image_path = IMAGE_SAVE_DIR . basename($objPage->arrProductsClass[$cnt]["main_image"]);
                if(file_exists($main_image_path)) {
                    list($image_width, $image_height) = getimagesize($main_image_path);
                } else {
                    $image_width = 0;
                    $image_height = 0;
                }

                $objPage->arrProductsClass[$cnt]["tpl_image_width"] = $image_width + 60;
                $objPage->arrProductsClass[$cnt]["tpl_image_height"] = $image_height + 80;

// ADD START
                // 切り売りの場合は単価にmを乗算する
                if (isset($arrCart[$i]['sell_piece_size'])) {
                    // 価格の登録
                    if ($arrData['price02'] != "") {
                        $p_price = round($arrCart[$i]['sell_piece_size'] * $arrData['price02']);
                        $objCartSess->setProductValue($arrCart[$i]['id'], 'price', $p_price);
                        $objPage->arrProductsClass[$cnt]['uniq_price'] = $p_price;
                    } else {
                        $p_price = round($arrCart[$i]['sell_piece_size'] * $arrData['price01']);
                        $objCartSess->setProductValue($arrCart[$i]['id'], 'price', $p_price);
                        $objPage->arrProductsClass[$cnt]['uniq_price'] = $p_price;
                    }
                    $objPage->arrProductsClass[$cnt]['sell_piece_size'] = $arrCart[$i]['sell_piece_size'];

                    // オーダーメイド商品の場合は長さによって計算する
                } elseif (isset($arrCart[$i]['body_color_classcategory_id'])) {

                    // 縦と横で長い方のcmにて金額計算する
                    $length = $arrCart[$i]['width_size'] >= $arrCart[$i]['height_size'] ? $arrCart[$i]['width_size'] : $arrCart[$i]['height_size'];
                    // 価格の登録
                    if ($arrData['price02'] != "") {
                        $p_price = round($length * $arrData['price02'] / 100);
                        //$objCartSess->setProductValue($arrCart[$i]['id'], 'price', $p_price);
                        $objCartSess->setProductValueOrderMade($arrCart[$i]['id'], 'price', $p_price, $arrCart[$i]['width_size'], $arrCart[$i]['height_size']);
                        $objPage->arrProductsClass[$cnt]['uniq_price'] = $p_price;
                    } else {
                        $p_price = round($length * $arrData['price01'] / 100);
                        //$objCartSess->setProductValue($arrCart[$i]['id'], 'price', $p_price);
                        $objCartSess->setProductValueOrderMade($arrCart[$i]['id'], 'price', $p_price, $arrCart[$i]['width_size'], $arrCart[$i]['height_size']);
                        $objPage->arrProductsClass[$cnt]['uniq_price'] = $p_price;
                    }
                    //echo "pri=$p_price<br>";

                    $objPage->arrProductsClass[$cnt]['body_color_classcategory_id'] = $arrCart[$i]['body_color_classcategory_id'];
                    $objPage->arrProductsClass[$cnt]['back_color_classcategory_id'] = $arrCart[$i]['back_color_classcategory_id'];
                    $objPage->arrProductsClass[$cnt]['edge_color_classcategory_id'] = $arrCart[$i]['edge_color_classcategory_id'];
                    $objPage->arrProductsClass[$cnt]['edge_size_classcategory_id'] = $arrCart[$i]['edge_size_classcategory_id'];
                    $objPage->arrProductsClass[$cnt]['width_size'] = $arrCart[$i]['width_size'];
                    $objPage->arrProductsClass[$cnt]['height_size'] = $arrCart[$i]['height_size'];
                    $objPage->arrProductsClass[$cnt]['body_color_classcategory_name'] = $this->sfGetClassCatName($arrCart[$i]['body_color_classcategory_id']);
                    $objPage->arrProductsClass[$cnt]['back_color_classcategory_name'] = $this->sfGetClassCatName($arrCart[$i]['back_color_classcategory_id']);
                    $objPage->arrProductsClass[$cnt]['edge_color_classcategory_name'] = $this->sfGetClassCatName($arrCart[$i]['edge_color_classcategory_id']);
                    $objPage->arrProductsClass[$cnt]['edge_size_classcategory_name'] = $this->sfGetClassCatName($arrCart[$i]['edge_size_classcategory_id']);
                } else {


                    // JBステンプレートの場合は長さによって計算する（判定は、表の色が設定されていない、かつ横幅が設定されているもの）
                    if (!isset($arrCart[$i]['body_color_classcategory_id']) && isset($arrCart[$i]['width_size'])) {
                        $objPage->arrProductsClass[$cnt]['width_size'] = $arrCart[$i]['width_size'];
                        $objPage->arrProductsClass[$cnt]['is_JBStainplate'] = true;
                    }
                    
                    // 購入制限数を求める。
                    if ($arrData['stock_unlimited'] != '1' && $arrData['sale_unlimited'] != '1') {
                        if($arrData['sale_limit'] < $arrData['stock']) {
                            $limit = $arrData['sale_limit'];
                        } else {
                            // 購入制限数を在庫数に
                            #$limit = $arrData['stock'];
                            // 購入制限数をSALE_LIMIT_MAXに
                            $limit = SALE_LIMIT_MAX;
                        }
                    } else {
                        if ($arrData['sale_unlimited'] != '1') {
                            $limit = $arrData['sale_limit'];
                        }
                        if ($arrData['stock_unlimited'] != '1') {
                            // 購入制限数を在庫数に
                            #$limit = $arrData['stock'];
                            // 購入制限数をSALE_LIMIT_MAXに
                            $limit = SALE_LIMIT_MAX;
                        }
                    }
// ADD END

                    // 価格の登録
                    if ($arrData['price02'] != "") {
                        $objCartSess->setProductValue($arrCart[$i]['id'], 'price', $arrData['price02']);
                        $objPage->arrProductsClass[$cnt]['uniq_price'] = $arrData['price02'];
                    } else {
                        $objCartSess->setProductValue($arrCart[$i]['id'], 'price', $arrData['price01']);
                        $objPage->arrProductsClass[$cnt]['uniq_price'] = $arrData['price01'];
                    }

// ADD START
                }
// ADD END

                // ポイント付与率の登録
                if (USE_POINT === true) {
                    $objCartSess->setProductValue($arrCart[$i]['id'], 'point_rate', $arrData['point_rate']);
                }
                // 商品ごとの合計金額
                $objPage->arrProductsClass[$cnt]['total_pretax'] = $objCartSess->getProductTotal($arrInfo, $arrCart[$i]['id']);
                // 送料の合計を計算する
                $objPage->tpl_total_deliv_fee+= ($arrData['deliv_fee'] * $arrCart[$i]['quantity']);
                $cnt++;


            } else { // DBに商品が見つからない場合はカート商品の削除
                $objPage->tpl_message .= "※申し訳ございませんが、ご購入の直前で売り切れた商品があります。該当商品をカートから削除いたしました。\n";
                // カート商品の削除
                $objCartSess->delProductKey('id', $arrCart[$i]['id']);
            }
        }

        // 全商品合計金額(税込み)
        $objPage->tpl_total_pretax = $objCartSess->getAllProductsTotal($arrInfo);
        // 全商品合計消費税
        $objPage->tpl_total_tax = $objCartSess->getAllProductsTax($arrInfo);
        // 全商品合計ポイント
        if (USE_POINT === true) {
            $objPage->tpl_total_point = $objCartSess->getAllProductsPoint();
        }

        return $objPage;
    }
*/

    /**
     * 指定したカテゴリーIDのカテゴリー名を取得する.
     *
     * @param integer $category_id カテゴリID
     * @return array 指定したカテゴリーIDのカテゴリー名
     */
    function sfGetProductName($product_id) {
        // 商品が属するカテゴリIDを縦に取得
        $objQuery =& SC_Query_Ex::getSingletonInstance();

        // カテゴリー名称を取得する
        $sql = "SELECT name FROM dtb_products WHERE product_id = ?";
        $arrVal = array($product_id);
        $name = $objQuery->getOne($sql, $arrVal);

        return $name;
    }

    function sfGetUnit($product_id) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $table = 'dtb_unit LEFT JOIN dtb_products USING (unit_id)';
        $where = "product_id = ?";
        $arrVal = array($product_id);
        $sql = "SELECT unit_name FROM {$table} WHERE {$where}";
        $ret = $objQuery->getOne($sql, $arrVal);

        if (SC_Utils_Ex::isBlank($ret)) $ret = '個';
        return $ret;
    }

    /**
     * 指定したカテゴリーIDのカテゴリー名を取得する.
     *
     * @param integer $category_id カテゴリID
     * @return array 指定したカテゴリーIDのカテゴリー名
     */
    function sfGetCatName($category_id) {
        // 商品が属するカテゴリIDを縦に取得
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrRet = array();
        $arrRet['id'] = $category_id;

        // カテゴリー名称を取得する
        $sql = "SELECT category_name FROM dtb_category WHERE category_id = ?";
        $arrVal = array($arrRet['id']);
        $arrRet['name'] = $objQuery->getOne($sql,$arrVal);

        return $arrRet;
    }

    /**
     * 指定したクラスカテゴリーIDのクラスカテゴリー名を取得する.
     *
     * @param integer $classcategory_id クラスカテゴリID
     * @return array 指定したクラスカテゴリーIDのカテゴリー名
     */
    function sfGetClassCatName($classcategory_id, $is_get_color = false) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();

        // カテゴリー名称を取得する
        $col = ($is_get_color) ? 'color' : 'name';
        $sql = "SELECT {$col} FROM dtb_classcategory WHERE classcategory_id = ?";
        $arrVal = array($classcategory_id);
        $ret = $objQuery->getOne($sql,$arrVal);

        return $ret;
    }

    /**
     * カテゴリIDから直下のIDを返す.
     *
     * @param integer $category_id カテゴリID
     * @return array 商品を検索する場合の配列
     */
    function sfGetCatUnderID($category_id) {
        // 子カテゴリIDの取得
        $arrChildsUnderID = SC_Helper_DB_Ex::sfGetChildsUnderID("dtb_category", "parent_category_id", "category_id", $category_id);
        $arrRet = array();

        foreach ($arrChildsUnderID as $child_category_id) {
            if ($child_category_id != $category_id) $arrRet[] = $child_category_id;
        }

        return $arrRet;
    }

    function sfGetChildsUnderID($table, $pid_name, $id_name, $id) {
        $arrRet = $this->sfGetChildrenUnderArray($table, $pid_name, $id_name, $id);
        return $arrRet;
    }

    /**
     * 階層構造のテーブルから直下の子ID配列を取得する.
     *
     * @param string $table テーブル名
     * @param string $pid_name 親ID名
     * @param string $id_name ID名
     * @param integer $id ID番号
     * @return array 子IDの配列
     */
    function sfGetChildrenUnderArray($table, $pid_name, $id_name, $id) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = "{$pid_name}, {$id_name}";
        $arrData = $objQuery->select($col, $table);
        $arrPID = array($id);

        $arrRet = SC_Helper_DB_Ex::sfGetChildrenUnderArraySub($arrData, $pid_name, $id_name, $arrPID);

        return $arrRet;
    }

    /**
     * 親ID直下の子IDをすべて取得する.
     *
     * @param array $arrData 親カテゴリの配列
     * @param string $pid_name 親ID名
     * @param string $id_name ID名
     * @param array $arrPID 親IDの配列
     * @return array 子IDの配列
     */
    function sfGetChildrenUnderArraySub($arrData, $pid_name, $id_name, $arrPID) {
        $arrChildren = array();
        $max = count($arrData);

        for($i = 0; $i < $max; $i++) {
            foreach($arrPID as $val) {
                if($arrData[$i][$pid_name] == $val) {
                    $arrChildren[] = $arrData[$i][$id_name];
                }
            }
        }
        return $arrChildren;
    }

// 未使用
//    /**
//    * 2009.05.07 パンくずリスト表示機能追加
//    **/
//    function sfGetTopicPath($category_id) {
//
//        // 商品が属するカテゴリIDを縦に取得
//        $objQuery =& SC_Query_Ex::getSingletonInstance();
//        $arrCatID = $this->sfGetParents($objQuery, "dtb_category", "parent_category_id", "category_id", $category_id);
//        $TopicPath = " > ";
//
//        // カテゴリー名称を取得
//        foreach($arrCatID as $key => $val){
//            $sql = "SELECT category_name FROM dtb_category WHERE category_id = ?";
//            $arrVal = array($val);
//            $CatName = $objQuery->getOne($sql, $arrVal);
//
//            if($val != $category_id){
//                $TopicPath .= '<a href="./list.php?category_id =' .$val. '">'. $CatName . '</a> >';
//            } else {
//                $TopicPath .= $CatName;
//            }
//        }
//
//        return $TopicPath;
//    }

    /**
    * 2009.05.07 パンくずリスト表示機能追加
    **/
    function sfGetTopicPath2($category_id) {
        // 商品が属するカテゴリIDを縦に取得
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        //$arrCatID = $this->sfGetParents('dtb_category', 'parent_category_id', 'category_id', $category_id);
        $arrCatID = SC_Helper_DB_Ex::sfGetParents('dtb_category', 'parent_category_id', 'category_id', $category_id);
        $TopicPath = '<a href="' . ROOT_URLPATH . '">トップページ</a>';

        // カテゴリー名称を取得
        $cnt = 0;
        foreach ($arrCatID as $key => $val) {
            $sql = 'SELECT category_name FROM dtb_category WHERE category_id = ?';
            $arrVal = array($val);
            $CatName = $objQuery->getOne($sql, $arrVal);
            if ($cnt == 0) {
                $TopicPath .= " > {$CatName}";
            } else {
                $TopicPath .= " > <a href=\"" . ROOT_URLPATH . "products/list/{$val}\">{$CatName}</a>";
            }
            $cnt++;
        }

        return $TopicPath;
    }

    /**
    * 2010.12.04 指定したカテゴリIDが含まれているかチェック
    **/
    function sfGetTopicPath3($category_id, $chk_id) {

        // 商品が属するカテゴリIDを縦に取得
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        //$arrCatID = $this->sfGetParents($objQuery, "dtb_category", "parent_category_id", "category_id", $category_id);
        //$arrCatID = $this->sfGetParents("dtb_category", "parent_category_id", "category_id", $category_id);
        $arrCatID = SC_Helper_DB_Ex::sfGetParents("dtb_category", "parent_category_id", "category_id", $category_id);

        // カテゴリー名称を取得
        $chk = 0;
        foreach($arrCatID as $key => $val){
            if( $val == $chk_id )    return true;
        }

        return false;
    }

}
