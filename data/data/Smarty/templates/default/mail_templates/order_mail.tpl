<!--{*
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
 *}-->
<!--{$arrOrder.order_name01}--> <!--{$arrOrder.order_name02}--> 様

<!--{$tpl_header}-->

【　受　注　番　号　】<!--{$arrOrder.order_id}-->

▼お客様情報
================================================================
【　お　　名　　前　】<!--{$arrOrder.order_name01}--> <!--{$arrOrder.order_name02}-->（<!--{$arrOrder.order_kana01}--> <!--{$arrOrder.order_kana02}-->） 様
【　メールアドレス　】<!--{$arrOrder.order_email}-->
【　郵　便　番　号　】<!--{$arrOrder.order_zip01}--><!--{$arrOrder.order_zip02}-->
【　ご　　住　　所　】<!--{$arrPref[$arrOrder.order_pref]}--><!--{$arrOrder.order_addr01}--><!--{$arrOrder.order_addr02}-->
【　電　話　番　号　】<!--{if $arrOrder.order_tel01 != ""}--><!--{$arrOrder.order_tel01}-->-<!--{$arrOrder.order_tel02}-->-<!--{$arrOrder.order_tel03}--><!--{/if}-->

【　携　帯　番　号　】<!--{if $arrOrder.order_fax01 != ""}--><!--{$arrOrder.order_fax01}-->-<!--{$arrOrder.order_fax02}-->-<!--{$arrOrder.order_fax03}--><!--{/if}-->

【　注　　文　　日　】<!--{$arrOrder.create_date|sfDispDBDate:false|h}-->
【　決　済　方　法　】<!--{$arrOrder.payment_method}-->
【　　備　　　考　　】<!--{$Message_tmp}-->
================================================================

<!--{if count($arrShipping) >= 1}-->
▼配送先情報
================================================================
<!--{foreach item=shipping name=shipping from=$arrShipping}-->
【　お　　名　　前　】<!--{$shipping.shipping_name01}-->　<!--{$shipping.shipping_name02}-->（<!--{$shipping.shipping_kana01}-->　<!--{$shipping.shipping_kana02}-->） 様
【　郵　便　番　号　】<!--{$shipping.shipping_zip01}--><!--{$shipping.shipping_zip02}-->
【　ご　　住　　所　】<!--{$arrPref[$shipping.shipping_pref]}--><!--{$shipping.shipping_addr01}--><!--{$shipping.shipping_addr02}-->
【　電　話　番　号　】<!--{$shipping.shipping_tel01}-->-<!--{$shipping.shipping_tel02}-->-<!--{$shipping.shipping_tel03}-->
【　お届け　希望日　】<!--{$shipping.shipping_date|date_format:"%Y/%m/%d"|default:"指定なし"}-->
【お届け希望　時間帯】<!--{$shipping.shipping_time|default:"指定なし"}-->
【　　備　　　考　　】<!--{$shipping.shipping_msg}-->
【　　送　　　料　　】<!--{$arrOrder.deliv_fee|number_format|default:0}-->円
【配　送　先　合　計】<!--{$arrOrder.payment_total|number_format|default:0}-->円
<!--{/foreach}-->
================================================================

<!--{/if}-->
<!--{if $arrOther.title.value}-->
▼<!--{$arrOther.title.name}-->情報
================================================================
<!--{foreach key=key item=item from=$arrOther}-->
<!--{if $key != "title"}-->
<!--{if $item.name != ""}--><!--{$item.name}-->：<!--{/if}--><!--{$item.value}-->
<!--{/if}-->
<!--{/foreach}-->
================================================================

<!--{/if}-->
▼商品詳細情報
================================================================
<!--{section name=cnt loop=$arrOrderDetail}--><!--{assign var=product_index value=$arrOrderDetail[cnt].product_id}-->
【　商　品　番　号　】<!--{$arrOrderDetail[cnt].product_code}-->
【　商　　品　　名　】<!--{$arrOrderDetail[cnt].product_name}-->
<!--{if $arrOrderDetail[cnt].body_color_classcategory_id == "" && $arrOrderDetail[cnt].width_size != ""}-->
　【　商　品　サイズ　】横サイズ：<!--{$arrOrderDetail[cnt].width_size}-->cm　縦サイズ：<!--{$arrOrderDetail[cnt].classcategory_name2}-->　
<!--{elseif $arrOrderDetail[cnt].body_color_classcategory_id != ""}-->
　【　商　品　カラー　】表の色：<!--{$arrOrderDetail[cnt].body_color_classcategory_name}-->　<!--{if $arrOrderDetail[cnt].back_color_classcategory_id != ""}-->　裏の色：<!--{$arrOrderDetail[cnt].back_color_classcategory_name}-->　<!--{/if}-->　フチの色：<!--{$arrOrderDetail[cnt].edge_color_classcategory_name}-->　フチサイズ：<!--{$arrOrderDetail[cnt].edge_size_classcategory_name}-->
　【　商　品　サイズ　】　横サイズ：<!--{$arrOrderDetail[cnt].width_size}-->cm　縦サイズ：<!--{$arrOrderDetail[cnt].height_size}-->cm　
<!--{elseif $arrOrderDetail[cnt].classcategory_name1 != "" || $arrOrderDetail[cnt].classcategory_name2 != ""}-->
　【　規格　】<!--{$arrOrderDetail[cnt].classcategory_name1}--> <!--{$arrOrderDetail[cnt].classcategory_name2}-->
<!--{/if}-->
【　価　格　(税込)　】<!--{$arrOrderDetail[cnt].price|sfCalcIncTax|number_format}-->円
【　　数　　　量　　】<!--{$arrOrderDetail[cnt].quantity}-->個
【　　小　　　計　　】<!--{assign var=tax_price value=$arrOrderDetail[cnt].price|sfCalcIncTax}--><!--{$tax_price*$arrOrderDetail[cnt].quantity|number_format|default:0}-->円
<!--{/section}-->
================================================================

▼総合計
================================================================
【　合計（消費税）　】<!--{$arrOrder.subtotal|number_format|default:0}-->円（うち消費税 ￥<!--{$arrOrder.tax|number_format|default:0}-->円）
【　値　　引　　き　】￥ <!--{$arrOrder.use_point+$arrOrder.discount|number_format|default:0}-->
【　送　料　合　計　】<!--{$arrOrder.deliv_fee|number_format|default:0}-->円（税込）
【決　済　手　数　料】<!--{$arrOrder.charge|number_format|default:0}-->円
----------------------------------------------------------------
【　総　　合　　計　】<!--{$arrOrder.payment_total|number_format|default:0}-->円
================================================================

<!--{if $arrOrder.customer_id && $smarty.const.USE_POINT !== false}-->
================================================================
<!--{* ご注文前のポイント {$tpl_user_point} pt *}-->
ご使用ポイント <!--{$arrOrder.use_point|default:0|number_format}--> pt
今回加算される予定のポイント <!--{$arrOrder.add_point|default:0|number_format}--> pt
現在の所持ポイント <!--{$arrCustomer.point|default:0|number_format}--> pt

<!--{/if}-->
<!--{$tpl_footer}-->
