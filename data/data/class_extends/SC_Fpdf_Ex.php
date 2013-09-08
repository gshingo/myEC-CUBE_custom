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

require_once CLASS_REALDIR . 'SC_Fpdf.php';

class SC_Fpdf_Ex extends SC_Fpdf {
    function __construct($download, $title, $tpl_pdf = 'nouhinsyo1.pdf') {
        parent::__construct($download, $title, $tpl_pdf);

        $this->label_cell[0] = '商品名 / 商品コード / [ 規格 ] / { オーダーメイド情報 } / (フレンジフリル)';
    }

    function setOrderData() {
        //parent::setOrderData();
        $arrOrder = array();
        // DBから受注情報を読み込む
        $this->lfGetOrderData($this->arrData['order_id']);

        // 購入者情報
        $text = '〒 '.$this->arrDisp['order_zip01'].' - '.$this->arrDisp['order_zip02'];
        $this->lfText(23, 43, $text, 10); //購入者郵便番号
        $text = $this->arrPref[$this->arrDisp['order_pref']] . $this->arrDisp['order_addr01'];
        $this->lfText(27, 47, $text, 10); //購入者都道府県+住所1
        $this->lfText(27, 51, $this->arrDisp['order_addr02'], 10); //購入者住所2
        $text = $this->arrDisp['order_name01'].'　'.$this->arrDisp['order_name02'].'　様';
        $this->lfText(27, 59, $text, 11); //購入者氏名

        // お届け先情報
        // FIXME:テンプレに[ ご注文日 ]などが印字されていたので、お届け先は右に印字
        $this->SetFont('SJIS', '', 10);
        $this->lfText(25, 125, SC_Utils_Ex::sfDispDBDate($this->arrDisp['create_date']), 10); //ご注文日
        $this->lfText(25, 135, $this->arrDisp['order_id'], 10); //注文番号
        $text = "〒 ".$this->arrDisp['shipping_zip01']." - ".$this->arrDisp['shipping_zip02'];
        $this->lfText(91, 125, $text, 10); //お届け先郵便番号
        $text = $this->arrPref[$this->arrDisp['shipping_pref']] . $this->arrDisp['shipping_addr01'];
        $this->lfText(95, 129, $text, 10); //お届け先都道府県+住所1
        $this->lfText(95, 133, $this->arrDisp['shipping_addr02'], 10); //お届け先住所2
        $text = $this->arrDisp['shipping_name01']."　".$this->arrDisp['shipping_name02']."　様";
        $this->lfText(95, 137, $text, 10); //お届け先氏名
        $this->SetFont('Gothic', 'B', 10);
        $this->lfText(91, 120, '[ お届け先 ]', null);

        //$this->lfText(144, 121, SC_Utils_Ex::sfDispDBDate($this->arrDisp['create_date']), 10); //ご注文日
        //$this->lfText(144, 131, $this->arrDisp['order_id'], 10); //注文番号

        $this->SetFont('Gothic', 'B', 15);
        $this->Cell(0, 10, $this->tpl_title, 0, 2, 'C', 0, '');  //文書タイトル（納品書・請求書）
        $this->Cell(0, 66, '', 0, 2, 'R', 0, '');
        $this->Cell(5, 0, '', 0, 0, 'R', 0, '');
        $this->SetFont('SJIS', 'B', 15);
        $this->Cell(67, 8, number_format($this->arrDisp['payment_total']).' 円', 0, 2, 'R', 0, '');
        $this->Cell(0, 45, '', 0, 2, '', 0, '');

        $this->SetFont('SJIS', '', 8);

        $monetary_unit = '円';
        $point_unit = 'Pt';

        // 購入商品情報
        for ($i = 0; $i < count($this->arrDisp['quantity']); $i++) {

            // 購入数量
            $data[0] = $this->arrDisp['quantity'][$i];

            // 税込金額（単価）
            $data[1] = SC_Helper_DB_Ex::sfCalcIncTax($this->arrDisp['price'][$i]);

            // 小計（商品毎）
            $data[2] = $data[0] * $data[1];

            $arrOrder[$i][0]  = $this->arrDisp['product_name'][$i].' / ';
            $arrOrder[$i][0] .= $this->arrDisp['product_code'][$i].' / ';
            if ($this->arrDisp['classcategory_name1'][$i]) {
                $arrOrder[$i][0] .= ' [ '.$this->arrDisp['classcategory_name1'][$i];
                // 生地の場合は選択した色を取得
                if (!SC_Utils_Ex::isBlank($this->arrDisp['classcategory_color1'][$i])) {
                    $arrOrder[$i][0] .= '：'.$this->arrDisp['classcategory_color1'][$i];
                }
                if ($this->arrDisp['classcategory_name2'][$i] == '') {
                    $arrOrder[$i][0] .= ' ]';
                } else {
                    //$arrOrder[$i][0] .= ' * '.$this->arrDisp['classcategory_name2'][$i].' ]';
                    $arrOrder[$i][0] .= ' * '.$this->arrDisp['classcategory_name2'][$i];
                    // 生地の場合は選択した色を取得
                    if (!SC_Utils_Ex::isBlank($this->arrDisp['classcategory_color2'][$i])) {
                        $arrOrder[$i][0] .= '：'.$this->arrDisp['classcategory_color2'][$i];
                    }
                    $arrOrder[$i][0] .= ' ]';
                }
            }
            // オーダーメイド(泥除け)情報------------------
            if (!empty($this->arrDisp['body_color_classcategory_name'][$i])
                || !empty($this->arrDisp['back_color_classcategory_name'][$i])
                || !empty($this->arrDisp['edge_color_classcategory_name'][$i])
                || !empty($this->arrDisp['edge_size_classcategory_name'][$i])
                || !empty($this->arrDisp['width_size'][$i])
                || !empty($this->arrDisp['height_size'][$i])
            ) {
                $arrOrder[$i][0] .= ' { ';
                $is_next = 0;
                if (!empty($this->arrDisp['body_color_classcategory_name'][$i])) {
                    $arrOrder[$i][0] .= '表の色：'.$this->arrDisp['body_color_classcategory_name'][$i];
                    $is_next = 1;
                }
                if (!empty($this->arrDisp['back_color_classcategory_name'][$i])) {
                    if ($is_next == 1) $arrOrder[$i][0] .= ' / ';
                    $arrOrder[$i][0] .= '裏の色：'.$this->arrDisp['back_color_classcategory_name'][$i];
                    $is_next = 1;
                }
                if (!empty($this->arrDisp['edge_color_classcategory_name'][$i])) {
                    if ($is_next == 1) $arrOrder[$i][0] .= ' / ';
                    $arrOrder[$i][0] .= 'フチの色：'.$this->arrDisp['edge_color_classcategory_name'][$i];
                    $is_next = 1;
                }
                if (!empty($this->arrDisp['edge_size_classcategory_name'][$i])) {
                    if ($is_next == 1) $arrOrder[$i][0] .= ' / ';
                    $arrOrder[$i][0] .= 'フチのサイズ：'.$this->arrDisp['edge_size_classcategory_name'][$i];
                    $is_next = 1;
                }
                if (!empty($this->arrDisp['width_size'][$i])) {
                    if ($is_next == 1) $arrOrder[$i][0] .= ' / ';
                    $arrOrder[$i][0] .= '横サイズ：'.$this->arrDisp['width_size'][$i].'cm';
                    $is_next = 1;
                }
                if (!empty($this->arrDisp['height_size'][$i])) {
                    if ($is_next == 1) $arrOrder[$i][0] .= ' / ';
                    $arrOrder[$i][0] .= '縦サイズ：'.$this->arrDisp['height_size'][$i].'cm';
                }
                $arrOrder[$i][0] .= ' } ';
            }
            if (!empty($this->arrDisp['frill_name'][$i])) {
                $arrOrder[$i][0] .= ' / ('.$this->arrDisp['frill_name'][$i].')';
            }


            $arrOrder[$i][1]  = number_format($data[0]);
            $arrOrder[$i][2]  = number_format($data[1]).$monetary_unit;
            $arrOrder[$i][3]  = number_format($data[2]).$monetary_unit;

        }

        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '';
        $arrOrder[$i][3] = '';

        $i++;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '商品合計';
        $arrOrder[$i][3] = number_format($this->arrDisp['subtotal']).$monetary_unit;

        $i++;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '送料';
        $arrOrder[$i][3] = number_format($this->arrDisp['deliv_fee']).$monetary_unit;

        $i++;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '手数料';
        $arrOrder[$i][3] = number_format($this->arrDisp['charge']).$monetary_unit;

        $i++;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '値引き';
        $arrOrder[$i][3] = '- '.number_format(($this->arrDisp['use_point'] * POINT_VALUE) + $this->arrDisp['discount']).$monetary_unit;

        $i++;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '請求金額';
        $arrOrder[$i][3] = number_format($this->arrDisp['payment_total']).$monetary_unit;

        // ポイント表記
        if ($this->arrData['disp_point'] && $this->arrDisp['customer_id']) {
            $i++;
            $arrOrder[$i][0] = '';
            $arrOrder[$i][1] = '';
            $arrOrder[$i][2] = '';
            $arrOrder[$i][3] = '';

            $i++;
            $arrOrder[$i][0] = '';
            $arrOrder[$i][1] = '';
            $arrOrder[$i][2] = '利用ポイント';
            $arrOrder[$i][3] = number_format($this->arrDisp['use_point']).$point_unit;

            $i++;
            $arrOrder[$i][0] = '';
            $arrOrder[$i][1] = '';
            $arrOrder[$i][2] = '加算ポイント';
            $arrOrder[$i][3] = number_format($this->arrDisp['add_point']).$point_unit;
        }

        $this->FancyTable($this->label_cell, $arrOrder, $this->width_cell);
    }

    // 受注データの取得
    function lfGetOrderData($order_id) {
        parent::lfGetOrderData($order_id);
        if (SC_Utils_Ex::sfIsInt($order_id)) {
            // DBから届け先情報を読み込む
            $objQuery =& SC_Query_Ex::getSingletonInstance();
            $where = 'order_id = ?';
            $col = 'shipping_name01, shipping_name02, shipping_kana01, shipping_kana02';
            $col .= ', shipping_tel01, shipping_tel02, shipping_tel03';
            $col .= ', shipping_fax01, shipping_fax02, shipping_fax03';
            $col .= ', shipping_pref, shipping_zip01, shipping_zip02, shipping_addr01, shipping_addr02';
            $col .= ', time_id, shipping_time, shipping_num, shipping_date, shipping_commit_date';
            $arrRet = $objQuery->select($col, 'dtb_shipping', $where, array($order_id));
            $this->arrDisp = array_merge($this->arrDisp, $arrRet[0]); // 複数お届け先指定はないので, １お届け先のみ挿入.
        }
    }

    // 受注詳細データの取得
    function lfGetOrderDetail($order_id) {
        //$arrForm = parent::lfGetOrderDetail($order_id);
        $objDb = new SC_Helper_DB_Ex();
        $objProduct = new SC_Product_Ex();
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = 'product_id, product_class_id, product_code, product_name, classcategory_name1, classcategory_name2, price, quantity, point_rate';
        $col .= ', body_color_classcategory_id, back_color_classcategory_id, edge_color_classcategory_id, edge_size_classcategory_id';
        $col .= ', width_size, height_size, frill_id';
        $where = 'order_id = ?';
        $objQuery->setOrder('order_detail_id');
        $arrRet = $objQuery->select($col, 'dtb_order_detail', $where, array($order_id));

        $col = 'classcategory_id1, classcategory_id2';
        foreach ($arrRet as $key => $detail) {
            $productClass = $objProduct->getProductsClass($detail['product_class_id']);
            if (!empty($productClass['classcategory_id1'])) {
                $arrRet[$key]['classcategory_color1'] = $objDb->sfGetClassCatName($productClass['classcategory_id1'], true);
            } else {
                $arrRet[$key]['classcategory_color1'] = '';
            }
            if (!empty($productClass['classcategory_id2'])) {
                $arrRet[$key]['classcategory_color2'] = $objDb->sfGetClassCatName($productClass['classcategory_id2'], true);
            } else {
                $arrRet[$key]['classcategory_color2'] = '';
            }
            if (!empty($detail['body_color_classcategory_id'])) {
                $arrRet[$key]['body_color_classcategory_name'] = $objDb->sfGetClassCatName($detail['body_color_classcategory_id']);
            } else {
                $arrRet[$key]['body_color_classcategory_name'] = '';
            }
            if (!empty($detail['back_color_classcategory_id'])) {
                $arrRet[$key]['back_color_classcategory_name'] = $objDb->sfGetClassCatName($detail['back_color_classcategory_id']);
            } else {
                $arrRet[$key]['back_color_classcategory_name'] = '';
            }
            if (!empty($detail['edge_color_classcategory_id'])) {
                $arrRet[$key]['edge_color_classcategory_name'] = $objDb->sfGetClassCatName($detail['edge_color_classcategory_id']);
            } else {
                $arrRet[$key]['edge_color_classcategory_name'] = '';
            }
            if (!empty($detail['edge_size_classcategory_id'])) {
                $arrRet[$key]['edge_size_classcategory_name'] = $objDb->sfGetClassCatName($detail['edge_size_classcategory_id']);
            } else {
                $arrRet[$key]['edge_size_classcategory_name'] = '';
            }
            if (!empty($detail['width_size'])) {
                //$arrRet[$key]['width_size'] = $objDb->sfGetClassCatName($detail['width_size']);
                $arrRet[$key]['width_size'] = $detail['width_size'];
            } else {
                $arrRet[$key]['width_size'] = '';
            }
            if (!empty($detail['height_size'])) {
                //$arrRet[$key]['height_size'] = $objDb->sfGetClassCatName($detail['height_size']);
                $arrRet[$key]['height_size'] = $detail['height_size'];
            } else {
                $arrRet[$key]['height_size'] = '';
            }
            if (!empty($detail['frill_id'])) {
                $frill_detail = $objProduct->getDetail($detail['frill_id']);
                $arrRet[$key]['frill_name'] = $frill_detail['name'];
            } else {
                $arrRet[$key]['frill_name'] = '';
            }
        }

        return $arrRet;
    }
}
