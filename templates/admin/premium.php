<style>
.section{
    margin-left: -20px;
    margin-right: -20px;
    font-family: "Raleway",san-serif;
}
.section h1{
    text-align: center;
    text-transform: uppercase;
    color: #808a97;
    font-size: 35px;
    font-weight: 700;
    line-height: normal;
    display: inline-block;
    width: 100%;
    margin: 50px 0 0;
}
.section ul{
    list-style-type: disc;
    padding-left: 15px;
}
.section:nth-child(even){
    background-color: #fff;
}
.section:nth-child(odd){
    background-color: #f1f1f1;
}
.section .section-title img{
    display: table-cell;
    vertical-align: middle;
    width: auto;
    margin-right: 15px;
}
.section h2,
.section h3 {
    display: inline-block;
    vertical-align: middle;
    padding: 0;
    font-size: 24px;
    font-weight: 700;
    color: #808a97;
    text-transform: uppercase;
}

.section .section-title h2{
    display: table-cell;
    vertical-align: middle;
    line-height: 25px;
}

.section-title{
    display: table;
}

.section h3 {
    font-size: 14px;
    line-height: 28px;
    margin-bottom: 0;
    display: block;
}

.section p{
    font-size: 13px;
    margin: 25px 0;
}
.section ul li{
    margin-bottom: 4px;
}
.landing-container{
    max-width: 750px;
    margin-left: auto;
    margin-right: auto;
    padding: 50px 0 30px;
}
.landing-container:after{
    display: block;
    clear: both;
    content: '';
}
.landing-container .col-1,
.landing-container .col-2{
    float: left;
    box-sizing: border-box;
    padding: 0 15px;
}
.landing-container .col-1 img{
    width: 100%;
}
.landing-container .col-1{
    width: 55%;
}
.landing-container .col-2{
    width: 45%;
}
.premium-cta{
    background-color: #808a97;
    color: #fff;
    border-radius: 6px;
    padding: 20px 15px;
}
.premium-cta:after{
    content: '';
    display: block;
    clear: both;
}
.premium-cta p{
    margin: 7px 0;
    font-size: 14px;
    font-weight: 500;
    display: inline-block;
    width: 60%;
}
.premium-cta a.button{
    border-radius: 6px;
    height: 60px;
    float: right;
    background: url(<?php echo YWCES_ASSETS_URL?>/images/upgrade.png) #ff643f no-repeat 13px 13px;
    border-color: #ff643f;
    box-shadow: none;
    outline: none;
    color: #fff;
    position: relative;
    padding: 9px 50px 9px 70px;
}
.premium-cta a.button:hover,
.premium-cta a.button:active,
.premium-cta a.button:focus{
    color: #fff;
    background: url(<?php echo YWCES_ASSETS_URL?>/images/upgrade.png) #971d00 no-repeat 13px 13px;
    border-color: #971d00;
    box-shadow: none;
    outline: none;
}
.premium-cta a.button:focus{
    top: 1px;
}
.premium-cta a.button span{
    line-height: 13px;
}
.premium-cta a.button .highlight{
    display: block;
    font-size: 20px;
    font-weight: 700;
    line-height: 20px;
}
.premium-cta .highlight{
    text-transform: uppercase;
    background: none;
    font-weight: 800;
    color: #fff;
}

.section.one{
    background: url(<?php echo YWCES_ASSETS_URL?>/images/01-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.two{
    background: url(<?php echo YWCES_ASSETS_URL?>/images/02-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.three{
    background: url(<?php echo YWCES_ASSETS_URL?>/images/03-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.four{
    background: url(<?php echo YWCES_ASSETS_URL?>/images/04-bg.png) no-repeat #fff; background-position: 85% 75%
}

@media (max-width: 768px) {
    .section{margin: 0}
    .premium-cta p{
        width: 100%;
    }
    .premium-cta{
        text-align: center;
    }
    .premium-cta a.button{
        float: none;
    }
}

@media (max-width: 480px){
    .wrap{
        margin-right: 0;
    }
    .section{
        margin: 0;
    }
    .landing-container .col-1,
    .landing-container .col-2{
        width: 100%;
        padding: 0 15px;
    }
    .section-odd .col-1 {
        float: left;
        margin-right: -100%;
    }
    .section-odd .col-2 {
        float: right;
        margin-top: 65%;
    }
}

@media (max-width: 320px){
    .premium-cta a.button{
        padding: 9px 20px 9px 70px;
    }

    .section .section-title img{
        display: none;
    }
}
</style>
<div class="landing">
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Coupon Email System%2$s to benefit from all features!','yith-woocommerce-coupon-email-system'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-woocommerce-coupon-email-system');?></span>
                    <span><?php _e('to the premium version','yith-woocommerce-coupon-email-system');?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="one section section-even clear">
        <h1><?php _e('Premium Features','yith-woocommerce-coupon-email-system');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCES_ASSETS_URL?>/images/01.png" alt="User email coupon" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCES_ASSETS_URL?>/images/01-icon.png" alt="icon 01"/>
                    <h2><?php _e('CUDDLE YOUR CUSTOMERS','yith-woocommerce-coupon-email-system');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Make your customers feel important, it is the only way to make business in the difficult world of the competition. Give them a warm welcome sending a coupon for their %1$snew registration%2$s, in order to encourage them to make their first purchase on your shop.%3$sAnd if you would like to wish your users a %1$shappy birthday%2$s, you can also take advantage of the chance to send a %1$scoupon%2$s as a gift for their special day. ! ', 'yith-woocommerce-coupon-email-system'), '<b>', '</b>','<br>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="two section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCES_ASSETS_URL?>/images/02-icon.png" alt="icon 02" />
                    <h2><?php _e('COMMEND USERS\' PURCHASES','yith-woocommerce-coupon-email-system');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Exploit the possibilities of the plugin to support more and more your users to purchase in your shop.%3$sReward with a coupon all the users that have reached a %1$sspecific spent amount%2$s in your shop, those who have made a certain %1$snumber of orders%2$s, or who have purchased some particular products.%3$sEven those who don\'t come back soon must be remembered: create and set a coupon to send to those users that didn\'t make a purchase since a specific number of days.', 'yith-woocommerce-coupon-email-system'), '<b>', '</b>','<br>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCES_ASSETS_URL?>/images/02.png" alt="COMMEND USERS' PURCHASES" />
            </div>
        </div>
    </div>
    <div class="three section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCES_ASSETS_URL?>/images/03.png" alt="4 EMAIL TEMPLATES" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCES_ASSETS_URL?>/images/03-icon.png" alt="icon 03" />
                    <h2><?php _e( '4 EMAIL TEMPLATES','yith-woocommerce-coupon-email-system');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('%1$sCustomize the layout of the generated emails%2$s for the sending of the coupons choosing among four different templates: you can find the best solution for your needs. In the end, every nice gift deserves a good package.', 'yith-woocommerce-coupon-email-system'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="four section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCES_ASSETS_URL?>/images/04-icon.png" alt="icon 04" />
                    <h2><?php _e('SEND EMAIL WITH MANDRILL','yith-woocommerce-coupon-email-system');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Use the powerful email service of %1$sMandrill%2$s to manage the sending of your coupons to your shop users.%3$sAn integration to those who want to use the best tool for their work.', 'yith-woocommerce-coupon-email-system'), '<b>', '</b>','<br>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCES_ASSETS_URL?>/images/04.png" alt="Mandrill integration" />
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Coupon Email System%2$s to benefit from all features!','yith-woocommerce-coupon-email-system'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-woocommerce-coupon-email-system');?></span>
                    <span><?php _e('to the premium version','yith-woocommerce-coupon-email-system');?></span>
                </a>
            </div>
        </div>
    </div>
</div>