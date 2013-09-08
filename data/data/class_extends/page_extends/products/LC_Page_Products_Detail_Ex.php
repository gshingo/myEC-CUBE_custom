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
require_once CLASS_REALDIR . 'pages/products/LC_Page_Products_Detail.php';

/**
 * LC_Page_Products_Detail のページクラス(拡張).
 *
 * LC_Page_Products_Detail をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id: LC_Page_Products_Detail_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class LC_Page_Products_Detail_Ex extends LC_Page_Products_Detail {

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
     * Page のAction.
     *
     * @return void
     */
    function action() {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = "classcategory_id, name, color, price_rank";
        $table = "dtb_classcategory";
        $arrJB = $objQuery->select($col, $table);

        // DBから各種情報を取得する
        // (単位、セミオーダーフラグ、切り売り可能フラグ)
        $col = "unit_id, semi_order_made_flg, sell_piece_flg, order_made_flg, back_color_class_id";
        $table = "dtb_products";
        $where = "product_id = ?";
        $arrUnit = $objQuery->select($col, $table, $where, array($_REQUEST['product_id']));
        $unit_id = $arrUnit[0]['unit_id'];
        $this->semi_order_flg = $arrUnit[0]['semi_order_made_flg'];
        $this->sell_piece_flg = $arrUnit[0]['sell_piece_flg'];
        $this->order_made_flg = $arrUnit[0]['order_made_flg'];
        if ($arrUnit[0]['back_color_class_id'] != "") $this->back_color_flg = 1;

        parent::action();

        if (SC_Utils_Ex::isBlank($unit_id) || $unit_id == 0) {
            $this->valUnit = '個';
        } else {
            $this->valUnit = $this->lfGetUnit($unit_id);
        }

        if ($this->order_made_flg == 1) {
            $this->arrBodyCategory = $this->lfGetSelect($this->arrProduct['body_color_class_id']);
            $this->arrBackCategory = $this->lfGetSelect($this->arrProduct['back_color_class_id']);
            $this->arrEdgeCategory = $this->lfGetSelect($this->arrProduct['edge_color_class_id']);
            $this->arrSizeCategory = $this->lfGetSelect($this->arrProduct['edge_size_class_id']);
        }

        // 追加規格設定
        $this->lfSetAddClassSetting($this->tpl_product_id);
        $this->tpl_title = "商品詳細 {$this->arrProduct['name']}";
    }

    /* プロダクトIDの正当性チェック */
    function lfCheckProductId($admin_mode,$product_id) {
        // 管理機能からの確認の場合は、非公開の商品も表示する。
        if (isset($admin_mode) && $admin_mode == 'on') {
            SC_Utils_Ex::sfIsSuccess(new SC_Session_Ex());
            $status = true;
            $where = 'del_flg = 0';
        } else {
            $status = false;
            //$where = 'del_flg = 0 AND status = 1';
            //$where = "del_flg = 0 AND status = 1 AND NOT (option_item_flg = 1)";
            $where = 'del_flg = 0 AND status = 1 AND option_item_flg <> 1';
        }

        if (!SC_Utils_Ex::sfIsInt($product_id)
            || SC_Utils_Ex::sfIsZeroFilling($product_id)
            || !SC_Helper_DB_Ex::sfIsRecord('dtb_products', 'product_id', (array)$product_id, $where)
        ) {
                SC_Utils_Ex::sfDispSiteError(PRODUCT_NOT_FOUND);
        }

        // $status の存在位置、$product_id の有無から、ここに追加
        // パンくずリスト表示機能
        $this->lfSetTopicPath($product_id, $status);

        return $product_id;
    }

    /* パラメーター情報の初期化 */
    function lfInitParam(&$objFormParam) {
        $objFormParam->addParam('JB横サイズ', 'JB_Size', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('規格1', 'getClassId1', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('規格2', 'getClassId2', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('切り売りサイズ', 'sell_piece_size', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('表の色', 'body_color_classcategory_id', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('裏の色', 'back_color_classcategory_id', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('フチの色', 'edge_color_classcategory_id', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('フチサイズ', 'edge_size_classcategory_id', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('横サイズ', 'width_size', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('縦サイズ', 'height_size', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('セミオプション', 'semi_option_id', INT_LEN, 'n', array('NUM_CHECK'));

        $arrForm = parent::lfInitParam($objFormParam);

        // 切り売り商品の際は個数チェック不要
        $objFormParam->overwriteParam('quantity', 'disp_name', '個数');
        if ($this->sell_piece_flg == 1) {
            $objFormParam->overwriteParam('quantity', 'arrCheck', array('ZERO_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
            $objFormParam->overwriteParam('sell_piece_size', 'arrCheck', array('EXIST_CHECK', 'ZERO_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
        }
        if ($this->order_made_flg == 1) {
            $objFormParam->overwriteParam('body_color_classcategory_id', 'arrCheck', array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
            if ($this->back_color_flg == 1) {
                $objFormParam->overwriteParam('back_color_classcategory_id', 'arrCheck', array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
            } else {
                $objFormParam->overwriteParam('back_color_classcategory_id', 'arrCheck', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
            }
            $objFormParam->overwriteParam('edge_color_classcategory_id', 'arrCheck', array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
            $objFormParam->overwriteParam('edge_size_classcategory_id', 'arrCheck', array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
            $objFormParam->overwriteParam('width_size', 'arrCheck', array('EXIST_CHECK', 'ZERO_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
            $objFormParam->overwriteParam('height_size', 'arrCheck', array('EXIST_CHECK', 'ZERO_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
        }
        if ($this->semi_order_flg == 1) {
            $objFormParam->overwriteParam('semi_option_id', 'arrCheck', array('EXIST_CHECK', 'NUM_CHECK'));
        }

        return $arrForm;
    }

    /* 入力内容のチェック */
    function lfCheckError($mode,&$objFormParam,$tpl_classcat_find1 = null ,$tpl_classcat_find2 = null) {
        // $arrErr = parent::lfCheckError($mode, $objFormParam, $tpl_classcat_find1, $tpl_classcat_find2);

        switch ($mode) {
        case 'add_favorite_sphone':
        case 'add_favorite':
            $objCustomer = new SC_Customer_Ex();
            $objErr = new SC_CheckError_Ex();
            $customer_id = $objCustomer->getValue('customer_id');
            if (SC_Helper_DB_Ex::sfDataExists('dtb_customer_favorite_products', 'customer_id = ? AND product_id = ?', array($customer_id, $favorite_product_id))) {
                $objErr->arrErr['add_favorite'.$favorite_product_id] = '※ この商品は既にお気に入りに追加されています。<br />';
            }
            break;
        default:
            // 入力データを渡す。
            $arrRet =  $objFormParam->getHashArray();
            $objErr = new SC_CheckError_Ex($arrRet);
            $objErr->arrErr = $objFormParam->checkError();

            // 複数項目チェック
            //if ($tpl_classcat_find1) {
            if ($tpl_classcat_find1 && SC_Utils_Ex::isBlank($arrRet['getClassId1'])) {
                //$objErr->doFunc(array('規格1', 'classcategory_id1'), array('EXIST_CHECK'));
                $name = (strpos($this->tpl_class_name1, '車種名') !== FALSE) ? '車種' : '規格';
                $objErr->doFunc(array($name, 'classcategory_id1'), array('EXIST_CHECK'));
            }
            //if ($tpl_classcat_find2) {
            if ($tpl_classcat_find2 && SC_Utils_Ex::isBlank($arrRet['getClassId2'])) {
                //$objErr->doFunc(array('規格2', 'classcategory_id2'), array('EXIST_CHECK'));
                $name = (strpos($this->tpl_class_name2, '車種名') !== FALSE) ? '車種' : '規格';
                $objErr->doFunc(array($name, 'classcategory_id2'), array('EXIST_CHECK'));
            }

            $this->tpl_JB_Size = $arrRet['JB_Size'];
            $getClassId1 = $arrRet['getClassId1'];
            $getClassId2 = $arrRet['getClassId2'];
            // 切り売り商品チェック
            if ($this->sell_piece_flg == 1) {
                // lfInitParam参照
            // オーダーメイド商品チェック
            } elseif ($this->order_made_flg == 1) {
                // lfInitParam参照
            // セミオーダーメイド商品チェック
            } elseif ($this->semi_order_flg == 1) {
                // lfInitParam参照
            // JBステンプレートチェック
            // FIXME:POST値を直接確認してる... フラグ化必要？？？
            } elseif ((isset($_POST['getClassId1']) || isset($_POST['getClassId2']))
                && isset($_POST['JB_Size'])
            ) {
                $size = $this->tpl_JB_Size * 10;
                if (!SC_Utils_Ex::isBlank($getClassId1)) {
                    $arrJB = $this->lfGetJBSize($size, $getClassId1);
                } else {
                    $arrJB = $this->lfGetJBSize($size, $getClassId2);
                }
                $JB_classcategory_id = $arrJB['classcategory_id'];

                if (SC_Utils_Ex::isBlank($JB_classcategory_id)) {
                    // 指定されたサイズが許容範囲外
                    $objErr->arrErr['JB_Size'] .= "※入力されたサイズは御座いません。";
                } else {
                    $this->JB_classcategory_id = $JB_classcategory_id;
                    // 商品値段を取得
                    if (!SC_Utils_Ex::isBlank($getClassId1)) {
                        $this->JBPrice = $this->lfGetJBPrice($JB_classcategory_id, '1');
                    } else {
                        $this->JBPrice = $this->lfGetJBPrice($JB_classcategory_id, '2');
                    }
                }
            }

            break;
        }

        return $objErr->arrErr;
    }

    /**
     * Add product(s) into the cart.
     *
     * @return void
     */
    function doCart() {
        $this->arrErr = $this->lfCheckError($this->mode,$this->objFormParam,
                                            $this->tpl_classcat_find1,
                                            $this->tpl_classcat_find2);
        /* lfCheckError へ移動
        $this->tpl_JB_Size = $this->objFormParam->getValue('JB_Size');*/
        $getClassId1 = $this->objFormParam->getValue('getClassId1');
        $getClassId2 = $this->objFormParam->getValue('getClassId2');
        /*if ((!SC_Utils_Ex::isBlank($getClassId1) || !SC_Utils_Ex::isBlank($getClassId2))
            && !SC_Utils_Ex::isBlank($this->tpl_JB_Size)
        ) {
            $size = $this->tpl_JB_Size * 10;
            if (!SC_Utils_Ex::isBlank($getClassId1)) {
                $arrJB = $this->lfGetJBSize($size, $getClassId1);
            } else {
                $arrJB = $this->lfGetJBSize($size, $getClassId2);
            }
            $JB_classcategory_id = $arrJB['classcategory_id'];

            if (SC_Utils_Ex::isBlank($JB_classcategory_id)) {
                // 指定されたサイズが許容範囲外
                $this->arrErr['JB_Size'] .= "※入力されたサイズは御座いません。";
            } else {
                // 商品値段を取得
                if (!SC_Utils_Ex::isBlank($getClassId1)) {
                    $this->JBPrice = $this->lfGetJBPrice($JB_classcategory_id, '1');
                } else {
                    $this->JBPrice = $this->lfGetJBPrice($JB_classcategory_id, '2');
                }
            }
        }
        */

        if (count($this->arrErr) == 0) {
            $objCartSess = new SC_CartSession_Ex();
            $product_class_id = $this->objFormParam->getValue('product_class_id');
            $product_id = $this->objFormParam->getValue('product_id');
            $classcategory_id1 = $this->objFormParam->getValue('classcategory_id1');
            if (!SC_Utils_Ex::isBlank($this->JB_classcategory_id)) $classcategory_id1 = $this->JB_classcategory_id;
            $classcategory_id2 = $this->objFormParam->getValue('classcategory_id2');
            if (!SC_Utils_Ex::isBlank($classcategory_id1) && !SC_Utils_Ex::isBlank($product_id)) {
                if (!SC_Utils_Ex::isBlank($classcategory_id2) && $classcategory_id1 != $classcategory_id2) {
                    $arrProductsClass = SC_Helper_DB_Ex::sfGetProductsClass(array($product_id, $classcategory_id1, $classcategory_id2));
                } else {
                    $arrProductsClass = SC_Helper_DB_Ex::sfGetProductsClass(array($product_id, $classcategory_id1));
                }
                if ($product_class_id != $arrProductsClass['product_class_id']) {
                    $product_class_id = $arrProductsClass['product_class_id'];
                }
            }

            //$objCartSess->addProduct($product_class_id, $this->objFormParam->getValue('quantity'));
            $quantity = $this->objFormParam->getValue('quantity');
            $sell_piece_size = $this->objFormParam->getValue('sell_piece_size');
            $body_color_id = $this->objFormParam->getValue('body_color_classcategory_id');
            if (!SC_Utils_Ex::isBlank($sell_piece_size)) {
                // 切り売り商品
                //$product_id = $this->objFormParam->getValue('product_id');
                //$classcategory_id1 = $this->objFormParam->getValue('classcategory_id1');
                //$arrProductsClass = SC_Helper_DB_Ex::sfGetProductsClass(array($product_id, $classcategory_id1));
                //$product_class_id = $arrProductsClass['product_class_id'];
                // 切り売りの際、個数入力は無いので自動で１個
                $objCartSess->addProduct_SellPiece($product_class_id, 1, $sell_piece_size);
            } elseif (!SC_Utils_Ex::isBlank($body_color_id)) {
                // オーダーメイド商品
                $back_color_id = $this->objFormParam->getValue('back_color_classcategory_id');
                $edge_color_id = $this->objFormParam->getValue('edge_color_classcategory_id');
                $edge_size_id = $this->objFormParam->getValue('edge_size_classcategory_id');
                $width_size = $this->objFormParam->getValue('width_size');
                $height_size = $this->objFormParam->getValue('height_size');
                $objCartSess->addProduct_Ordermade($product_class_id, $quantity,
                                                   $body_color_id, $back_color_id,
                                                   $edge_color_id, $edge_size_id,
                                                   $width_size, $height_size);
            //} elseif (!SC_Utils_Ex::isBlank($getClassId1) || !SC_Utils_Ex::isBlank($getClassId2)) {
            } elseif (!SC_Utils_Ex::isBlank($this->tpl_JB_Size)) {
                // JBステンプレート商品
                $objCartSess->addProduct_JBStainplate($product_class_id, $quantity, $this->tpl_JB_Size);
            } else {
                $semi_option_id = $this->objFormParam->getValue('semi_option_id');
                if (!SC_Utils_Ex::isBlank($semi_option_id)) {
                    // セミオーダーオプション商品
                    $objCartSess->addProduct($product_class_id, $quantity, $semi_option_id);
                } else {
                    // 通常商品
                    $objCartSess->addProduct($product_class_id, $quantity);
                }
            }

            SC_Response_Ex::sendRedirect(CART_URLPATH);
            SC_Response_Ex::actionExit();
        }
    }

    /* 規格選択セレクトボックスの作成(モバイル) */
    function lfMakeSelectMobile(&$objPage, $product_id,$request_classcategory_id1) {

        $classcat_find1 = false;
        $classcat_find2 = false;

        // 規格名一覧
        $arrClassName = SC_Helper_DB_Ex::sfGetIDValueList('dtb_class', 'class_id', 'name');
        // 規格分類名一覧
        $arrClassCatName = SC_Helper_DB_Ex::sfGetIDValueList('dtb_classcategory', 'classcategory_id', 'name');
        // 商品規格情報の取得
        $arrProductsClass = $this->lfGetProductsClass($product_id);

        // 規格1クラス名の取得
        $objPage->tpl_class_name1 = $arrClassName[$arrProductsClass[0]['class_id1']];
        // 規格2クラス名の取得
        $objPage->tpl_class_name2 = $arrClassName[$arrProductsClass[0]['class_id2']];

        // すべての組み合わせ数
        $count = count($arrProductsClass);

        $classcat_id1 = '';

        $arrSele1 = array();
        $arrSele2 = array();

        for ($i = 0; $i < $count; $i++) {
            // 在庫のチェック
            if ($arrProductsClass[$i]['stock'] <= 0 && $arrProductsClass[$i]['stock_unlimited'] != '1') {
                continue;
            }

            // 規格1のセレクトボックス用
            if ($classcat_id1 != $arrProductsClass[$i]['classcategory_id1']) {
                $classcat_id1 = $arrProductsClass[$i]['classcategory_id1'];
            }

            // 規格2のセレクトボックス用
            //if ($arrProductsClass[$i]['classcategory_id1'] == $request_classcategory_id1 and $classcat_id2 != $arrProductsClass[$i]['classcategory_id2']) {
            if ($classcat_id2 != $arrProductsClass[$i]['classcategory_id2']) {
                $classcat_id2 = $arrProductsClass[$i]['classcategory_id2'];
                $arrSele2[$classcat_id2] = $arrClassCatName[$classcat_id2];
            }
        }

        // 規格1
        $objPage->arrClassCat1 = $arrSele1;
        $objPage->arrClassCat2 = $arrSele2;

        // 規格1が設定されている
        if (isset($arrProductsClass[0]['classcategory_id1']) && $arrProductsClass[0]['classcategory_id1'] != '0') {
            $classcat_find1 = true;
        }

        // 規格2が設定されている
        if (isset($arrProductsClass[0]['classcategory_id2']) && $arrProductsClass[0]['classcategory_id2'] != '0') {
            $classcat_find2 = true;
        }

        $objPage->tpl_classcat_find1 = $classcat_find1;
        $objPage->tpl_classcat_find2 = $classcat_find2;
    }

    function lfSetTopicPath($product_id, $status) {
        $objDb = new SC_Helper_DB_Ex();
        $arrCategory_id = $objDb->sfGetCategoryId($product_id, '', $status);
        $arrTopicPath = $objDb->sfGetTopicPath2($arrCategory_id[0]);
        $this->tpl_topicpath = $arrTopicPath;
    }

    function lfGetJBSize($size, $class_id) {
        if (!is_numeric($size)) return false;
        if (!SC_Utils_Ex::sfIsInt($class_id)) return false;

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = 'classcategory_id, under_size, upper_size';
        $table = 'dtb_classcategory';
        $where = 'class_id = ? AND under_size <= ? AND upper_size >= ?';
        $arrVal = array($class_id, $size, $size);
        $arrJB = $objQuery->select($col, $table, $where, $arrVal);

        return $arrJB[0];
    }

    function lfGetJBPrice($classcategory_id, $target) {
        if (!SC_Utils_Ex::sfIsInt($classcategory_id)) return false;

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $table = 'dtb_products_class';
        $where = "classcategory_id{$target} = ?";
        $arrVal = array($classcategory_id);
        $sql = "SELECT price02 FROM {$table} WHERE {$where}";
        $ret = $objQuery->getOne($sql, $arrVal);

        return $ret;
    }

    function lfGetUnit($unit_id) {
        if (!SC_Utils_Ex::sfIsInt($unit_id)) return false;

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $table = 'dtb_unit';
        $where = "unit_id = ?";
        $arrVal = array($unit_id);
        $sql = "SELECT unit_name FROM {$table} WHERE {$where}";
        $ret = $objQuery->getOne($sql, $arrVal);

        return $ret;
    }

    /* セレクトボックスの作成 */
    function lfGetSelect($class_id) {
        if (!SC_Utils_Ex::sfIsInt($class_id)) return array();
        $arrRet = array();

        // 規格分類名一覧
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $keyname = 'classcategory_id';
        $valname = 'name';

        $table = 'dtb_classcategory';
        $col = "{$keyname}, {$valname}";
        $where = 'del_flg = 0 and class_id = ?';
        $objQuery->setOrder('rank DESC');
        $arrList = $objQuery->select($col, $table, $where, array($class_id));

        //$count = count($arrList);
        //for($cnt = 0; $cnt < $count; $cnt++) {
        //    $key = $arrList[$cnt][$keyname];
        //    $val = $arrList[$cnt][$valname];
        //    $arrRet[$key] = $val;
        //}

        foreach ($arrList as $ret) {
            $arrRet[$ret[$keyname]] = $ret[$valname];
        }

        return $arrRet;
    }

    function lfSetAddClassSetting($product_id) {
        // 更新前の tpl_class_name1, tpl_class_name2 を使っていたため先に設定
        // 選択されてる規格が「車種名」の時は表示を変える対応
        $this->tpl_class_cartype_flg1 = 0;
        $this->tpl_class_cartype_flg2 = 0;
        if (strpos($this->tpl_class_name1, '車種名') !== FALSE) {
            $this->tpl_class_cartype_flg1 = 1;
            $this->objFormParam->overwriteParam('classcategory_id1', 'disp_name', '車種');
        }
        if (strpos($this->tpl_class_name2, '車種名') !== FALSE) {
            $this->tpl_class_cartype_flg2 = 1;
            $this->objFormParam->overwriteParam('classcategory_id2', 'disp_name', '車種');
        }

        $objDb = new SC_Helper_DB_Ex();

        // 規格名一覧
        $arrClassName = $objDb->sfGetIDValueList('dtb_class', 'class_id', 'name');
        // 規格分類名一覧
        $arrClassCatName = $objDb->sfGetIDValueList('dtb_classcategory', 'classcategory_id', 'name');
        // 商品規格情報の取得
        $arrProductsClass = $this->lfGetProductsClass($product_id);

        $arrSele2 = array();
        foreach ($arrProductsClass as $productClass) {
            if ($classcat_id2 != $productClass['classcategory_id2']) {
                $classcat_id2 = $productClass['classcategory_id2'];
                if ($arrClassCatName[$classcat_id2] != '') {
                    $arrSele2[$classcat_id2] = $arrClassCatName[$classcat_id2];
                }
            }
        }
        $this->arrClassCat2 = $arrSele2;

        $class_id1 = $arrProductsClass[0]['class_id1'];
        $class_id2 = $arrProductsClass[0]['class_id2'];
        // 規格1クラス名の取得
        $this->tpl_class_name1 = isset($arrClassName[$class_id1]) ? $arrClassName[$class_id1] : '';
        // 規格2クラス名の取得
        $this->tpl_class_name2 = isset($arrClassName[$class_id2]) ? $arrClassName[$class_id2] : '';

        $this->tpl_class_id1 = $class_id1;
        $this->tpl_class_id2 = $class_id2;

        //生地管理フラグ割当機能
        $this->tpl_cloth_flg1 = $this->lfGetClothFlg($class_id1);
        $this->tpl_cloth_flg2 = $this->lfGetClothFlg($class_id2);

        // サブ情報の有無判定フラグ(画像に対してのみ)
        $this->other_img_flg = false;
        for ($i=1; $i<PRODUCTSUB_MAX; $i++) {
            if (strlen($this->arrProduct["sub_image{$i}"]) >= 1) {
                $this->other_img_flg = true;
                break;
            }
        }
    }

    function lfGetClothFlg($class_id) {
        if ($class_id == '') return false;

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrData = $objQuery->select('*', 'dtb_class', 'class_id = ?', array($class_id));
        return $arrData[0]['cloth_flg'];
    }

}
