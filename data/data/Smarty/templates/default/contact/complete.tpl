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

<div id="undercolumn">
    <h2 class="title"><img src="<!--{$TPL_URLPATH}-->img/contact/title.jpg" width="710" height="40" alt="お問い合わせ" /></h2>
    <div id="undercolumn_contact">
        <div id="complete_area">
            <span class="message">お問い合わせ内容の送信が完了いたしました。</span><br />
            万一、ご回答メールが届かない場合は、トラブルの可能性もありますので大変お手数ではございますがもう一度お問い合わせいただくか、お電話にてお問い合わせください。<br />
            今後ともご愛顧賜りますようよろしくお願い申し上げます。
            <div id="shop_information">
            <p><span class="name"><!--{$arrSiteInfo.company_name|h}--><span><br />
                TEL：<!--{$arrSiteInfo.tel01}-->-<!--{$arrSiteInfo.tel02}-->-<!--{$arrSiteInfo.tel03}-->
                <!--{if $arrSiteInfo.business_hour != ""}-->
                （受付時間/<!--{$arrSiteInfo.business_hour}-->）
                <!--{/if}--><br />
                E-mail：<a href="mailto:<!--{$arrSiteInfo.email02|escape:'hex'}-->"><!--{$arrSiteInfo.email02|escape:'hexentity'}--></a>
            </p>
            </div>
        </div>

            <div class="btn_area">
                <a href="<!--{$smarty.const.TOP_URLPATH}-->" onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/common/b_toppage_on.gif','b_toppage');" onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/common/b_toppage.gif','b_toppage');"><img src="<!--{$TPL_URLPATH}-->img/common/b_toppage.gif" alt="トップページへ" border="0" name="b_toppage" id="b_toppage" /></a>
            </div>
    </div>
</div>
