<div class="header" style="border: 0; font: inherit; font-size: 100%; margin: 0; padding: 0; vertical-align: baseline;">
    <div class="header-top__line" style="background-color: #2072b5; border: 0; font: inherit; font-size: 100%; line-height: 48px; margin: 0; padding: 0; vertical-align: baseline;">
        @widget('menu', ['template' => 'for_email'])
        <div class="profile" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; padding: 0; padding-right: 22px; text-align: right; vertical-align: baseline; width: 147px;">
            <a href="{{ url('/profile') }}" style="border: 0; color: #fff; font: inherit; font-size: 14px; margin: 0; padding: 0; text-decoration: none; vertical-align: baseline;"><span class="icon" style="background: url(http://alshan.kz/email/img/icon/email-icon-user.png); border: 0; display: inline-block; font: inherit; font-size: 100%; height: 17px; margin: 1px 11px 0 0; padding: 0; text-decoration: none; vertical-align: middle; width: 17px;"></span>Личный кабинет</a>
        </div>
    </div>
    <div class="container" style="border: 0; font: inherit; font-size: 100%; margin: 0; padding: 0 18px 0 20px; vertical-align: baseline;">
        <div class="header-info" style="border: 0; font: inherit; font-size: 0; margin: 0; margin-top: 19px; padding: 0; vertical-align: baseline;">
            <a href="{{ url('/') }}" class="logo" style="background: url({{ url('/static/img/email-logo.png') }}); border: 0; display: inline-block; font: inherit; font-size: 0; height: 56px; margin: 0; padding: 0; vertical-align: top; width: 202px;">a</a>
            <div class="header-contact" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; margin-left: 54px; padding: 0; vertical-align: baseline;">
                <a href="skype:{{ _setting('phone') }}" class="phone" style="border: 0; color: #232323; display: block; float: left; font: inherit; font-size: 18px; line-height: 56px; margin: 0; margin-right: 33px; padding: 0; text-decoration: none; vertical-align: baseline;"><span class="icon icon-phone" style="background: url(http://alshan.kz/email/img/icon/email-icon-phone.png); border: 0; display: inline-block; font: inherit; font-size: 100%; height: 18px; line-height: 18px; margin: 0; margin-right: 8px; padding: 0; vertical-align: middle; width: 23px;"></span>{{ _setting('phone') }}</a>
                <a href="mailto:{{ _setting('email_site') }}" class="email" style="border: 0; color: #232323; display: block; float: left; font: inherit; font-size: 18px; line-height: 56px; margin: 0; margin-right: 26px; padding: 0; text-decoration: none; vertical-align: baseline;"><span class="icon icon-email" style="background: url(http://alshan.kz/email/img/icon/email-icon-email.png); border: 0; display: inline-block; font: inherit; font-size: 100%; height: 14px; line-height: 18px; margin: 0; margin-right: 10px; padding: 0; vertical-align: middle; width: 20px;"></span>{{ _setting('email_site') }}</a>
                <div style="border: 0; color: #232323; display: block; float: left; font: inherit; font-size: 18px; line-height: 56px; margin: 0; padding: 0; text-decoration: none; vertical-align: baseline;"><span class="icon icon-schedule" style="background: url(http://alshan.kz/email/img/icon/email-icon-schedule.png); border: 0; display: inline-block; font: inherit; font-size: 100%; height: 16px; line-height: 18px; margin: 0; margin-right: 10px; padding: 0; vertical-align: middle; width: 16px;"></span>{{ _setting('work_time') }}</div>
            </div>
        </div>
    </div>

</div>