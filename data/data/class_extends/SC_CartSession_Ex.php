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

require_once CLASS_REALDIR . 'SC_CartSession.php';

class SC_CartSession_Ex extends SC_CartSession {

    /**
     * カートが保持するキー(商品種別ID)を配列で返す.
     *
     * @return array 商品種別IDの配列
     */
    function getKeys() {
        $keys = array_keys($this->cartSession);
        // 数量が 0 の商品種別は削除する
        //foreach ($keys as $key) {
        //    $quantity = $this->getTotalQuantity($key);
        //    if ($quantity < 1) {
        //        unset($this->cartSession[$key]);
        //    }
        //}
        return array_keys($this->cartSession);
    }

    // 値のセット
    function setProductValueOrderMade($product_class_id, $key, $val, $width_size, $height_size) {
        $objProduct = new SC_Product_Ex();
        $arrProduct = $objProduct->getProductsClass($product_class_id);
        $productTypeId = $arrProduct['product_type_id'];
        $max = $this->getMax($productTypeId);
        for ($i = 0; $i <= $max; $i++) {
            if (isset($this->cartSession[$productTypeId][$i]['id'])
                && $this->cartSession[$productTypeId][$i]['id'] == $product_class_id
                && $this->cartSession[$productTypeId][$i]['width_size'] == $width_size
                && $this->cartSession[$productTypeId][$i]['height_size'] == $height_size
            ) {
                $this->cartSession[$productTypeId][$i][$key] = $val;
            }
        }
    }

    // カートへの商品追加
    function addProduct($product_class_id, $quantity, $semi_option_id = 0) {
        $objProduct = new SC_Product_Ex();
        $arrProduct = $objProduct->getProductsClass($product_class_id);
        $productTypeId = $arrProduct['product_type_id'];
        $find = false;
        $max = $this->getMax($productTypeId);
        for ($i = 0; $i <= $max; $i++) {

            //if ($this->cartSession[$productTypeId][$i]['id'] == $product_class_id) {
            if ($this->cartSession[$productTypeId][$i]['id'] == $product_class_id
                && (($semi_option_id == 0)
                    || ($semi_option_id != 0 && $this->cartSession[$productTypeId][$i]['semi_option_id'] == $semi_option_id)
                )
            ) {
                $val = $this->cartSession[$productTypeId][$i]['quantity'] + $quantity;
                if (strlen($val) <= INT_LEN) {
                    $this->cartSession[$productTypeId][$i]['quantity'] += $quantity;
                    if (!empty($semi_option_id)) {
                        $this->cartSession[$productTypeId][$i]['semi_option_id'] = $semi_option_id;
                    }
                }
                $find = true;
            }
        }
        if (!$find) {
            $this->cartSession[$productTypeId][$max+1]['id'] = $product_class_id;
            $this->cartSession[$productTypeId][$max+1]['quantity'] = $quantity;
            $this->cartSession[$productTypeId][$max+1]['cart_no'] = $this->getNextCartID($productTypeId);
            $this->cartSession[$productTypeId][$max+1]['semi_option_id'] = $semi_option_id;
        }
    }

    // カートへの商品追加(JBステンプレート)
    function addProduct_JBStainplate($product_class_id, $quantity, $width) {
        $objProduct = new SC_Product_Ex();
        $arrProduct = $objProduct->getProductsClass($product_class_id);
        $productTypeId = $arrProduct['product_type_id'];
        $find = false;
        $max = $this->getMax($productTypeId);
        for ($i = 0; $i <= $max; $i++) {

            if ($this->cartSession[$productTypeId][$i]['id'] == $product_class_id
                && $this->cartSession[$productTypeId][$i]['width_size'] == $width
            ) {
                $val = $this->cartSession[$productTypeId][$i]['quantity'] + $quantity;
                if (strlen($val) <= INT_LEN) {
                    $this->cartSession[$productTypeId][$i]['quantity'] += $quantity;
                }
                $find = true;
            }
        }
        if (!$find) {
            $this->cartSession[$productTypeId][$max+1]['id'] = $product_class_id;
            $this->cartSession[$productTypeId][$max+1]['quantity'] = $quantity;
            $this->cartSession[$productTypeId][$max+1]['cart_no'] = $this->getNextCartID($productTypeId);
            $this->cartSession[$productTypeId][$max+1]['width_size'] = $width;
        }
    }

    // カートへの商品追加(切り売り)
    function addProduct_SellPiece($product_class_id, $quantity, $sell_piece_size) {
        $objProduct = new SC_Product_Ex();
        $arrProduct = $objProduct->getProductsClass($product_class_id);
        $productTypeId = $arrProduct['product_type_id'];
        $find = false;
        $max = $this->getMax($productTypeId);
        for ($i = 0; $i <= $max; $i++) {

            if ($this->cartSession[$productTypeId][$i]['id'] == $product_class_id) {
                //$val = $this->cartSession[$productTypeId][$i]['quantity'] + $quantity;
                $val = $this->cartSession[$productTypeId][$i]['sell_piece_size'] + $sell_piece_size;
                if (strlen($val) <= INT_LEN) {
                    //$this->cartSession[$productTypeId][$i]['quantity'] += $quantity;
                    $this->cartSession[$productTypeId][$i]['sell_piece_size'] += $sell_piece_size;
                }
                $find = true;
            }
        }
        if (!$find) {
            $this->cartSession[$productTypeId][$max+1]['id'] = $product_class_id;
            $this->cartSession[$productTypeId][$max+1]['quantity'] = $quantity;
            $this->cartSession[$productTypeId][$max+1]['cart_no'] = $this->getNextCartID($productTypeId);
            if (!empty($sell_piece_size)) {
                $this->cartSession[$productTypeId][$max+1]['sell_piece_size'] = $sell_piece_size;
            }
        }
    }

    // カートへの商品追加(オーダーメイド)
    function addProduct_Ordermade($product_class_id, $quantity, $body_color, $back_color, $edge_color, $edge_size, $width, $height) {
        $objProduct = new SC_Product_Ex();
        $arrProduct = $objProduct->getProductsClass($product_class_id);
        $productTypeId = $arrProduct['product_type_id'];
        $find = false;
        $max = $this->getMax($productTypeId);
        for ($i = 0; $i <= $max; $i++) {

            // 同じ生地でかつ表の色・裏の色・フチの色・縦・横が同一の場合のみ加算する
            //if ($this->cartSession[$productTypeId][$i]['id'] == $product_class_id) {
            if ($this->checkSameCloth($i, $productTypeId, $product_class_id,
                                      $body_color, $back_color, $edge_color, $edge_size,
                                      $width, $height)
            ) {
                $val = $this->cartSession[$productTypeId][$i]['quantity'] + $quantity;
                if (strlen($val) <= INT_LEN) {
                    $this->cartSession[$productTypeId][$i]['quantity'] += $quantity;
                }
                $find = true;
            }
        }
        if (!$find) {
            $this->cartSession[$productTypeId][$max+1]['id'] = $product_class_id;
            $this->cartSession[$productTypeId][$max+1]['quantity'] = $quantity;
            $this->cartSession[$productTypeId][$max+1]['cart_no'] = $this->getNextCartID($productTypeId);
            $this->cartSession[$productTypeId][$max+1]['body_color_classcategory_id'] = $body_color;
            $this->cartSession[$productTypeId][$max+1]['back_color_classcategory_id'] = $back_color;
            $this->cartSession[$productTypeId][$max+1]['edge_color_classcategory_id'] = $edge_color;
            $this->cartSession[$productTypeId][$max+1]['edge_size_classcategory_id'] = $edge_size;
            $this->cartSession[$productTypeId][$max+1]['width_size'] = $width;
            $this->cartSession[$productTypeId][$max+1]['height_size'] = $height;
        }
    }

    // 同じ生地でかつ表の色・裏の色・フチの色・縦・横が同一かどうかチェックします
    function checkSameCloth($i, $productTypeId, $id, $body_color, $back_color, $edge_color, $edge_size, $width, $height) {
        $result = false;

        if (isset($this->cartSession[$productTypeId])
            && $this->cartSession[$productTypeId][$i]['id'] == $id
            && $this->cartSession[$productTypeId][$i]['body_color_classcategory_id'] == $body_color
            && $this->cartSession[$productTypeId][$i]['back_color_classcategory_id'] == $back_color
            && $this->cartSession[$productTypeId][$i]['edge_color_classcategory_id'] == $edge_color
            && $this->cartSession[$productTypeId][$i]['edge_size_classcategory_id'] == $edge_size
            && $this->cartSession[$productTypeId][$i]['width_size'] == $width
            && $this->cartSession[$productTypeId][$i]['height_size'] == $height
        ) {
            $result = true;
        }

        return $result;
    }

    /**
     * 商品種別ごとにカート内商品の一覧を取得する.
     *
     * @param integer $productTypeId 商品種別ID
     * @return array カート内商品一覧の配列
     */
    function getCartList($productTypeId) {
        //parent::getCartList($productTypeId);
        $objDb = new SC_Helper_DB_Ex();
        $objProduct = new SC_Product_Ex();
        $max = $this->getMax($productTypeId);
        $arrRet = array();
        for ($i = 0; $i <= $max; $i++) {
            if (isset($this->cartSession[$productTypeId][$i]['cart_no'])
                && $this->cartSession[$productTypeId][$i]['cart_no'] != '') {

                // 商品情報は常に取得
                // TODO 同一インスタンス内では1回のみ呼ぶようにしたい
                $this->cartSession[$productTypeId][$i]['productsClass']
                    =& $objProduct->getDetailAndProductsClass($this->cartSession[$productTypeId][$i]['id']);

                $price = $this->cartSession[$productTypeId][$i]['productsClass']['price02'];
                // 商品の性質ごとに各種設定
                // 切り売りの場合は単価にmを乗算する
                if (isset($this->cartSession[$productTypeId][$i]['sell_piece_size'])) {
                    $price = round($this->cartSession[$productTypeId][$i]['sell_piece_size'] * $price);
                // オーダーメイド商品の場合は長さによって計算する
                } elseif (isset($this->cartSession[$productTypeId][$i]['body_color_classcategory_id'])) {
                    // 縦と横で長い方のcmにて金額計算する
                    if ($this->cartSession[$productTypeId][$i]['width_size'] >= $this->cartSession[$productTypeId][$i]['height_size']) {
                        $length = $this->cartSession[$productTypeId][$i]['width_size'];
                    } else {
                        $length = $this->cartSession[$productTypeId][$i]['height_size'];
                    }
                    $price = round($length * $price / 100);
                } else {
                    // JBステンプレートの場合は長さによって計算する（判定は、表の色が設定されていない、かつ横幅が設定されているもの）
                    if (!isset($this->cartSession[$productTypeId][$i]['body_color_classcategory_id'])
                        && isset($this->cartSession[$productTypeId][$i]['width_size'])
                    ) {
                        $this->cartSession[$productTypeId][$i]['is_JBStainplate'] = true;
                    }
                }
                $this->cartSession[$productTypeId][$i]['price'] = $price;

                $this->cartSession[$productTypeId][$i]['point_rate']
                    = $this->cartSession[$productTypeId][$i]['productsClass']['point_rate'];

                $quantity = $this->cartSession[$productTypeId][$i]['quantity'];
                $incTax = SC_Helper_DB_Ex::sfCalcIncTax($price);
                $total = $incTax * $quantity;

                $this->cartSession[$productTypeId][$i]['total_inctax'] = $total;

                $body_color_id = $this->cartSession[$productTypeId][$i]['body_color_classcategory_id'];
                if (!empty($body_color_id)) {
                    $this->cartSession[$productTypeId][$i]['body_color_classcategory_name'] = $objDb->sfGetClassCatName($body_color_id);
                }
                $back_color_id = $this->cartSession[$productTypeId][$i]['back_color_classcategory_id'];
                if (!empty($back_color_id)) {
                    $this->cartSession[$productTypeId][$i]['back_color_classcategory_name'] = $objDb->sfGetClassCatName($back_color_id);
                }
                $edge_color_id = $this->cartSession[$productTypeId][$i]['edge_color_classcategory_id'];
                if (!empty($edge_color_id)) {
                    $this->cartSession[$productTypeId][$i]['edge_color_classcategory_name'] = $objDb->sfGetClassCatName($edge_color_id);
                }
                $edge_size_id = $this->cartSession[$productTypeId][$i]['edge_size_classcategory_id'];
                if (!empty($edge_size_id)) {
                    $this->cartSession[$productTypeId][$i]['edge_size_classcategory_name'] = $objDb->sfGetClassCatName($edge_size_id);
                }

                $classcategory_id1 = $this->cartSession[$productTypeId][$i]['productsClass']['classcategory_id1'];
                if (!empty($classcategory_id1)) {
                    $this->cartSession[$productTypeId][$i]['color1'] = $objDb->sfGetClassCatName($classcategory_id1, true);
                }
                $classcategory_id2 = $this->cartSession[$productTypeId][$i]['productsClass']['classcategory_id2'];
                if (!empty($classcategory_id2)) {
                    $this->cartSession[$productTypeId][$i]['color2'] = $objDb->sfGetClassCatName($classcategory_id2, true);
                }

                $frill_id = $this->cartSession[$productTypeId][$i]['semi_option_id'];
                if (!empty($frill_id) && $frill_id > 0) {
                    $this->cartSession[$productTypeId][$i]['frill_name'] = $objDb->sfGetProductName($frill_id);
                }

                $arrRet[] = $this->cartSession[$productTypeId][$i];

                // セッション変数のデータ量を抑制するため、一部の商品情報を切り捨てる
                // XXX 上で「常に取得」するのだから、丸ごと切り捨てて良さそうにも感じる。
                $this->adjustSessionProductsClass($this->cartSession[$productTypeId][$i]['productsClass']);
            }
        }
        return $arrRet;
    }
}
