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
require_once CLASS_REALDIR . 'pages/admin/products/LC_Page_Admin_Products_Product.php';

/**
 * 商品登録 のページクラス(拡張).
 *
 * LC_Page_Admin_Products_Product をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id: LC_Page_Admin_Products_Product_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class LC_Page_Admin_Products_Product_Ex extends LC_Page_Admin_Products_Product {

    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();

        $this->arrOPTIONITEM = array(
            1 => "登録",
            2 => "非登録",
        );
        $this->arrEVENT = $this->lfGetEvent();
        $this->arrUNIT = $this->lfGetUnit();
        $this->arrClass = $this->lfGetClass();
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
     * 有効なイベント情報の取得
     *
     * @return array イベント情報
     */
    function lfGetEvent($event_id = null) {
        $arrEvent = $this->lfGetTableData('event', $event_id);
        return $arrEvent;
    }

    /* 単位情報の読み込み */
    function lfGetUnit($unit_id = null) {
        $arrUnit = $this->lfGetTableData('unit', $unit_id);
        return $arrUnit;
    }

    function lfGetClass($class_id = null) {
        $arrClass = $this->lfGetTableData('class', $class_id);
        return $arrClass;
    }

    function lfGetTableData($key, $id = null, $is_disp_options = true) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = '*';
        $table = "dtb_{$key}";
        $where = 'del_flg = 0';
        $arrVal = array();
        $setOrderType = ($key == 'class') ? 'update_date DESC' : 'update_date';
        $objQuery->setOrder($setOrderType);

        if (SC_Utils_Ex::sfIsInt($id)) {
            $where .= " AND {$key}_id = ?";
            $arrVal[] = $id;
        }

        $arrData = $objQuery->select($col, $table, $where, $arrVal);

        if ($is_disp_options) {
            $arrTemp = $arrData;
            $arrData = array();
            foreach ($arrTemp as $data) {
                $data_key = $data["{$key}_id"];
                $data_name = (isset($data["{$key}_name"])) ? $data["{$key}_name"] : $data["name"];
                $arrData[$data_key] = $data_name;
            }
        }

        return $arrData;
    }

    /* 商品に紐づいたイベントIDの読み込み */
    function lfGetEventProducts($product_id) {
        if (SC_Utils_Ex::isBlank($product_id)) return array();
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = 'event_id';
        $table = 'dtb_event_products';
        $where = 'product_id = ?';

        //$arrRet = $objQuery->select($col, $table, $where, array($product_id));
        $arrRet = $objQuery->getCol($col, $table, $where, array($product_id));
        return $arrRet;
    }

    /**
     * パラメーター情報の初期化
     *
     * @param object $objFormParam SC_FormParamインスタンス
     * @param array $arrPost $_POSTデータ
     * @return void
     */
    function lfInitFormParam(&$objFormParam, $arrPost) {
        $objFormParam->addParam('イベント登録', 'event_flg', INT_LEN, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('セミオーダー商品', 'semi_order_made_flg', INT_LEN, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('セミオーダーオプション商品', 'option_item_flg', INT_LEN, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('切り売り可能商品', 'sell_piece_flg', INT_LEN, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('表示単位', 'unit_id', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('表の色選択', 'body_color_class_id', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('裏の色選択', 'back_color_class_id', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('フチの色選択', 'edge_color_class_id', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('フチのサイズ選択', 'edge_size_class_id', INT_LEN, 'n', array('NUM_CHECK'));

        parent::lfInitFormParam(&$objFormParam, $arrPost);
    }

    /**
     * フォームパラメーター取得
     * - 編集/複製モード
     *
     * @param object $objUpFile SC_UploadFileインスタンス
     * @param object $objDownFile SC_UploadFileインスタンス
     * @param integer $product_id 商品ID
     * @return array フォームパラメーター配列
     */
    function lfGetFormParam_PreEdit(&$objUpFile, &$objDownFile, $product_id) {
        $arrForm = parent::lfGetFormParam_PreEdit($objUpFile, $objDownFile, $product_id);

        // イベント状態の取得
        $arrEventProducts = $this->lfGetEventProducts($product_id);
        $arrForm['event_flg'] = $arrEventProducts;

        return $arrForm;
    }

    /**
     * 表示用フォームパラメーター取得
     * - 入力画面
     *
     * @param object $objUpFile SC_UploadFileインスタンス
     * @param object $objDownFile SC_UploadFileインスタンス
     * @param array $arrForm フォーム入力パラメーター配列
     * @return array 表示用フォームパラメーター配列
     */
    function lfSetViewParam_InputPage(&$objUpFile, &$objDownFile, &$arrForm) {
        $arrForm = parent::lfSetViewParam_InputPage($objUpFile, $objDownFile, $arrForm);

        // デフォルト値設定：デフォルトは2:非登録
        $semi_order_flg = ($arrForm['semi_order_made_flg'] == '1') ? 1 : 2;
        $option_flg = ($arrForm['option_item_flg'] == '1') ? 1 : 2;
        $sel_piece_flg = ($arrForm['sel_piece_flg'] == '1') ? 1 : 2;
        $arrForm['semi_order_made_flg'] = $semi_order_flg;
        $arrForm['option_item_flg'] = $option_flg;
        $arrForm['sell_piece_flg'] = $sel_piece_flg;

        // オーダーメイド情報ありなしフラグ
        $arrForm['ordermade_find'] = $this->hasOrderMadeData($arrForm);

        return $arrForm;
    }

    function hasOrderMadeData($arrForm) {
        // オーダーメイド商品情報の入力があるかどうかチェックする
        $ordermade_find = false;
        if (!SC_Utils_Ex::isBlank($arrForm['body_color_class_id'])
            || !SC_Utils_Ex::isBlank($arrForm['back_color_class_id'])
            || !SC_Utils_Ex::isBlank($arrForm['edge_color_class_id'])
            || !SC_Utils_Ex::isBlank($arrForm['edge_size_class_id'])
        ) {
            $ordermade_find = true;
        }
        // オーダーメイド商品情報表示・非表示のチェックに使用する。
        return $ordermade_find;
    }

    /**
     * DBに商品データを登録する
     * イベント情報の同時登録のため, parent は使わずにオーバーライド.
     *
     * @param object $objUpFile SC_UploadFileインスタンス
     * @param object $objDownFile SC_UploadFileインスタンス
     * @param array $arrList フォーム入力パラメーター配列
     * @return integer 登録商品ID
     */
    function lfRegistProduct(&$objUpFile, &$objDownFile, $arrList) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objDb = new SC_Helper_DB_Ex();

        // 配列の添字を定義
        $checkArray = array('name', 'status',
                            'main_list_comment', 'main_comment',
                            'deliv_fee', 'comment1', 'comment2', 'comment3',
                            'comment4', 'comment5', 'comment6',
                            //'sale_limit', 'deliv_date_id', 'maker_id', 'note');
                            'sale_limit', 'deliv_date_id', 'maker_id', 'note',
                            'unit_id', 'body_color_class_id', 'back_color_class_id',
                            'edge_color_class_id', 'edge_size_class_id', 
        );
        $arrList = SC_Utils_Ex::arrayDefineIndexes($arrList, $checkArray);

        // INSERTする値を作成する。
        $sqlval['name'] = $arrList['name'];
        $sqlval['status'] = $arrList['status'];
        $sqlval['main_list_comment'] = $arrList['main_list_comment'];
        $sqlval['main_comment'] = $arrList['main_comment'];
        $sqlval['comment1'] = $arrList['comment1'];
        $sqlval['comment2'] = $arrList['comment2'];
        $sqlval['comment3'] = $arrList['comment3'];
        $sqlval['comment4'] = $arrList['comment4'];
        $sqlval['comment5'] = $arrList['comment5'];
        $sqlval['comment6'] = $arrList['comment6'];
        $sqlval['deliv_date_id'] = $arrList['deliv_date_id'];
        $sqlval['maker_id'] = $arrList['maker_id'];
        $sqlval['note'] = $arrList['note'];
        $sqlval['update_date'] = 'CURRENT_TIMESTAMP';
        $sqlval['creator_id'] = $_SESSION['member_id'];
        $sqlval['unit_id'] = $arrList['unit_id'];
        $sqlval['option_item_flg'] = $arrList['option_item_flg'];
        $sqlval['semi_order_made_flg'] = $arrList['semi_order_made_flg'];
        $sqlval['sell_piece_flg'] = $arrList['sell_piece_flg'];
        // オーダーメイド商品
        if ($this->hasOrderMadeData($arrList)) {
            $sqlval['order_made_flg'] = '1';
        } else {
            $sqlval['order_made_flg'] = '0';
        }
        $sqlval['body_color_class_id'] = $arrList['body_color_class_id'];
        $sqlval['back_color_class_id'] = $arrList['back_color_class_id'];
        $sqlval['edge_color_class_id'] = $arrList['edge_color_class_id'];
        $sqlval['edge_size_class_id'] = $arrList['edge_size_class_id'];
        $arrRet = $objUpFile->getDBFileList();
        $sqlval = array_merge($sqlval, $arrRet);

        for ($cnt = 1; $cnt <= PRODUCTSUB_MAX; $cnt++) {
            $sqlval['sub_title'.$cnt] = $arrList['sub_title'.$cnt];
            $sqlval['sub_comment'.$cnt] = $arrList['sub_comment'.$cnt];
        }

        $objQuery->begin();

        // 新規登録(複製時を含む)
        if ($arrList['product_id'] == '') {
            $product_id = $objQuery->nextVal('dtb_products_product_id');
            $sqlval['product_id'] = $product_id;

            // INSERTの実行
            $sqlval['create_date'] = 'CURRENT_TIMESTAMP';
            $objQuery->insert('dtb_products', $sqlval);

            $arrList['product_id'] = $product_id;

            // カテゴリを更新
            $objDb->updateProductCategories($arrList['category_id'], $product_id);

            // 複製商品の場合には規格も複製する
            if ($arrList['copy_product_id'] != '' && SC_Utils_Ex::sfIsInt($arrList['copy_product_id'])) {
                if ($this->lfGetProductClassFlag($arrList['has_product_class']) == false) {
                    //規格なしの場合、複製は価格等の入力が発生しているため、その内容で追加登録を行う
                    $this->lfCopyProductClass($arrList, $objQuery);
                } else {
                    //規格がある場合の複製は複製元の内容で追加登録を行う
                    // dtb_products_class のカラムを取得
                    $dbFactory = SC_DB_DBFactory_Ex::getInstance();
                    $arrColList = $objQuery->listTableFields('dtb_products_class');
                    $arrColList_tmp = array_flip($arrColList);

                    // 複製しない列
                    unset($arrColList[$arrColList_tmp['product_class_id']]);     //規格ID
                    unset($arrColList[$arrColList_tmp['product_id']]);           //商品ID
                    unset($arrColList[$arrColList_tmp['create_date']]);

                    // 複製元商品の規格データ取得
                    $col = SC_Utils_Ex::sfGetCommaList($arrColList);
                    $table = 'dtb_products_class';
                    $where = 'product_id = ?';
                    $objQuery->setOrder('product_class_id');
                    $arrProductsClass = $objQuery->select($col, $table, $where, array($arrList['copy_product_id']));

                    // 規格データ登録
                    $objQuery =& SC_Query_Ex::getSingletonInstance();
                    foreach ($arrProductsClass as $arrData) {
                        $sqlval = $arrData;
                        $sqlval['product_class_id'] = $objQuery->nextVal('dtb_products_class_product_class_id');
                        $sqlval['deliv_fee'] = $arrList['deliv_fee'];
                        $sqlval['point_rate'] = $arrList['point_rate'];
                        $sqlval['sale_limit'] = $arrList['sale_limit'];
                        $sqlval['product_id'] = $product_id;
                        $sqlval['create_date'] = 'CURRENT_TIMESTAMP';
                        $sqlval['update_date'] = 'CURRENT_TIMESTAMP';
                        $objQuery->insert($table, $sqlval);
                    }
                }
            }
        // 更新
        } else {
            $product_id = $arrList['product_id'];
            // 削除要求のあった既存ファイルの削除
            $arrRet = $this->lfGetProductData_FromDB($arrList['product_id']);
            // TODO: SC_UploadFile::deleteDBFileの画像削除条件見直し要
            $objImage = new SC_Image_Ex($objUpFile->temp_dir);
            $arrKeyName = $objUpFile->keyname;
            $arrSaveFile = $objUpFile->save_file;
            $arrImageKey = array();
            foreach ($arrKeyName as $key => $keyname) {
                if ($arrRet[$keyname] && !$arrSaveFile[$key]) {
                    $arrImageKey[] = $keyname;
                    $has_same_image = $this->lfHasSameProductImage($arrList['product_id'], $arrImageKey, $arrRet[$keyname]);
                    if (!$has_same_image) {
                        $objImage->deleteImage($arrRet[$keyname], $objUpFile->save_dir);
                    }
                }
            }
            $objDownFile->deleteDBDownFile($arrRet);
            // UPDATEの実行
            $where = 'product_id = ?';
            $objQuery->update('dtb_products', $sqlval, $where, array($product_id));

            // カテゴリを更新
            $objDb->updateProductCategories($arrList['category_id'], $product_id);
        }

        // 商品登録の時は規格を生成する。複製の場合は規格も複製されるのでこの処理は不要。
        if ($arrList['copy_product_id'] == '') {
            // 規格登録
            if ($objDb->sfHasProductClass($product_id)) {
                // 規格あり商品（商品規格テーブルのうち、商品登録フォームで設定するパラメーターのみ更新）
                $this->lfUpdateProductClass($arrList);
            } else {
                // 規格なし商品（商品規格テーブルの更新）
                $this->lfInsertDummyProductClass($arrList);
            }
        }

        // 商品ステータス設定
        $objProduct = new SC_Product_Ex();
        $objProduct->setProductStatus($product_id, $arrList['product_status']);

        // 関連商品登録
        $this->lfInsertRecommendProducts($objQuery, $arrList, $product_id);

        // イベント情報登録
        $this->lfRegistEvent($objQuery, $product_id, $arrList['event_flg']);

        $objQuery->commit();
        return $product_id;
    }

    /**
     * イベント情報を設定する.
     *
     * FIXME: event_product_id が要らない感じ...
     *
     * @param integer $product_id 商品ID
     * @param array $arrEventFlg ON にするイベントIDの配列
     */
    function lfRegistEvent(&$objQuery, $product_id, $arrEventFlg) {
        $table = 'dtb_event_products';

        $val['product_id'] = $product_id;
        //$val['creator_id'] = $_SESSION['member_id'];
        $val['create_date'] = 'CURRENT_TIMESTAMP';
        $val['update_date'] = 'CURRENT_TIMESTAMP';
        $val['del_flg'] = '0';

        $objQuery->delete($table, 'product_id = ?', array($product_id));
        foreach ($arrEventFlg as $event_id) {
            if ($event_id == '') continue;
            $event_product_id = $objQuery->nextVal('dtb_event_products_event_product_id');
            $val['event_product_id'] = $event_product_id;
            $val['event_id'] = $event_id;
            $objQuery->insert($table, $val);
        }
    }
}
