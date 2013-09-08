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

<div id="under02column">
    <div id="under02column_shopping">
        <p class="flow_area">
            <img src="<!--{$TPL_URLPATH}-->img/shopping/flow04.gif" width="700" height="36" alt="購入手続きの流れ" />
        </p>
        <h2 class="title"><img src="<!--{$TPL_URLPATH}-->img/shopping/complete_title.jpg" width="700" height="40" alt="ご注文完了" /></h2>

        <!-- ▼その他決済情報を表示する場合は表示 -->
        <!--{if $arrOther.title.value}-->
            <p><span class="message">■<!--{$arrOther.title.name}-->情報</span><br />
                <!--{foreach key=key item=item from=$arrOther}-->
                    <!--{if $key != "title"}-->
                        <!--{if $item.name != ""}-->
                            <!--{$item.name}-->：
                        <!--{/if}-->
                            <!--{$item.value|nl2br}--><br />
                    <!--{/if}-->
                <!--{/foreach}-->
            </p>
        <!--{/if}-->
        <!-- ▲コンビに決済の場合には表示 -->

        <div id="complete_area">
            <span class="message"><!--{$arrInfo.shop_name|h}-->の商品をご購入いただき、ありがとうございました。</span>
            <p>ただいま、ご注文の確認メールをお送りさせていただきました。<br />
                万一、ご確認メールが届かない場合は、トラブルの可能性もありますので大変お手数ではございますがもう一度お問い合わせいただくか、お電話にてお問い合わせくださいませ。<br />
                今後ともご愛顧賜りますようよろしくお願い申し上げます。</p>

            <div class="shop_information">
                <p><span class="name"><!--{$arrInfo.shop_name|h}--></span><br />
                TEL：<!--{$arrInfo.tel01}-->-<!--{$arrInfo.tel02}-->-<!--{$arrInfo.tel03}--> <!--{if $arrInfo.business_hour != ""}-->（受付時間/<!--{$arrInfo.business_hour}-->）<!--{/if}--><br />
                E-mail：<a href="mailto:<!--{$arrInfo.email02|escape:'hex'}-->"><!--{$arrInfo.email02|escape:'hexentity'}--></a>
                </p>
            </div>
        </div>

        <div class="btn_area">
            <a href="<!--{$smarty.const.TOP_URLPATH}-->" onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/common/b_toppage_on.gif','b_toppage');" onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/common/b_toppage.gif','b_toppage');"><img src="<!--{$TPL_URLPATH}-->img/common/b_toppage.gif" alt="トップページへ" border="0" name="b_toppage" /></a>
        </div>

    </div>
<!-- Google Code for &#36092;&#20837; Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1001575271;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "qs9VCOGI3gEQ56bL3QM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/1001575271/?label=qs9VCOGI3gEQ56bL3QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript">
    var pageTracker = _gat._getTracker("UA-10534560-2");
    pageTracker._initData();
    pageTracker._trackPageview();

    pageTracker._addTrans(
    "<!--{$orderId}-->", // Order ID
    "", // Affiliation
    "<!--{$total}-->", // Total
    "<!--{$tax}-->", // Tax
    "<!--{$deliv_fee}-->", // Shipping
    "", // City
    "<!--{$order_pref}-->", // State
    "日本" // Country
    );

    <!--{foreach item=tmpArr from=$arrProducts}-->
        pageTracker._addItem(
        "<!--{$orderId}-->", // 注文番号
        "<!--{$tmpArr.product_id}-->", // SKU(在庫管理単位の品番)
        "<!--{$tmpArr.product_name}-->", // 商品名 
        "", // 商品カテゴリ
        "<!--{$tmpArr.price}-->", // 商品単価
        "<!--{$tmpArr.quantity}-->" // 数量
        );
    <!--{/foreach}-->
    
    pageTracker._trackTrans();
</script>

<!-- レコメンドCVタグ -->
<script type="text/javascript">
if (!window._rcmdjp) document.write(unescape("%3Cscript src='" + document.location.protocol + "//d.rcmd.jp/www.route-2.net/item/recommend.js' type='text/javascript' charset='UTF-8'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try{
  var items = {};
<!--{*
  <!--{section name=cnt loop=$arrProductsClass}-->
  items['<!--{$arrProductsClass[cnt].product_id}-->'] = <!--{$arrProductsClass[cnt].quantity}-->;
  <!--{/section}-->
*}-->
  <!--{section name=cnt loop=$arrProducts}-->
  items['<!--{$arrProducts[cnt].product_id}-->'] = <!--{$arrProducts[cnt].quantity}-->;
  <!--{/section}-->
  _rcmdjp._trackConversion(items);
} catch(err) {}
</script>

<!-- Yahoo!コンバージョンタグ 2011-10-26以降 -->
<!-- Yahoo Code for &#12523;&#12540;&#12488;2 Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var yahoo_conversion_id = 1000007105;
var yahoo_conversion_label = "gQ_VCNW4nwQQ0_nQ5wM";
var yahoo_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="https://s.yimg.jp/images/listing/tool/cv/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://b91.yahoo.co.jp/pagead/conversion/1000007105/?label=gQ_VCNW4nwQQ0_nQ5wM&amp;guid=ON&amp;script=0&amp;disvt=true"/>
</div>
</noscript>

<!-- Google Code for &#36092;&#20837;&#23436;&#20102; Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1002882554;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "y5JzCI7mhwQQ-oub3gM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/1002882554/?value=0&amp;label=y5JzCI7mhwQQ-oub3gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
</div>
