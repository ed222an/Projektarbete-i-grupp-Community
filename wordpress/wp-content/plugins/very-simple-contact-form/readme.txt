=== Very Simple Contact Form ===
Contributors: Guido07111975
Version: 3.3
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Requires at least: 3.7
Tested up to: 4.2
Stable tag: trunk
Tags: simple, responsive, contact, contactform, email, honeypot, captcha, widget, custom, style, css, editor


== Changelog ==
Version 3.3
- removed 'extract' from files vscf_main and vscf_widget_form
- adjusted code in files vscf_main and vscf_widget_form
- added Swedish translation (thanks Bo Ahlqvist)

Version 3.2
- request: changed required number of characters from 3 to 2 (name and subject field)
- fixed bug with captcha not working properly in widget (in version 3.1)
- added Italian translation (thanks Antonio Melcore)

Version 3.1
- cleaned up code in files vscf_main and vscf_widget_form
- added Turkish translation (thanks WordCommerce)

Version 3.0
- major update
- added Custom Style editor: you can change the layout (CSS) of your form using the custom style page in WP dashboard
- linebreaks in textarea field are allowed now
- updated language files with help from nice users listed below and Google Translate

Version 2.9
- fixed bug in locale of Catalan, Croatian and Estonian language  
- added Slovenian translation (thanks Maja Blejec)

Version 2.8
- form will now use theme styling for input fields and submit button. If not supported in your theme you can activate plugin styling in file vscf_style
- added Estonian translation (thanks Villem Kuusk)

Version 2.7
- added Polish translation (thanks Milosz Raczkowski)
- replaced all divs with paragraph tags for better form display

Version 2.6
- added file vscf_widget_form
- fixed bug with widget: now you can use form and widget on same website
- updated language files

Version 2.5
- major update
- added file vscf_widget
- added Very Simple Contact Form widget: now you can display form in sidebar too
- updated language files

Version 2.4
- major update
- added anti-spam: honeypot fields and a simple captcha sum
- adjusted stylesheet
- updated language files

Version 2.3
- fixed small coding error in file vscf_main

Version 2.2
- added Danish language (thanks Borge Kolding)
- updated FAQ
- adjusted stylesheet

Version 2.1
- adjusted stylesheet
- updated language files

Version 2.0
- major update
- removed function vscf_clean_input and replaced it with default WP function sanitize_text_field: now all UTF-8 characters are supported!
- added Catalan translation (thanks Miquel Serrat)
- updated FAQ

Version 1.9
- added Croatian translation (thanks Dario Abram)
- added FAQ

Version 1.8
- adjusted function vscf_clean_input. Only allowed: letters (a-z), digits (0-10), space, point, hyphen and comma
- added Brazilian Portuguese translation (thanks Gustavo Lucas)

Version 1.7
- changed shortcode 'email' into 'email_to' (to avoid possible conflict with the email input field)
- added name and email in text of message to admin

Version 1.6
- updated several translation files
- added Spanish translation (thanks Alvaro Reig Gonzalez)

Version 1.5
- several small frontend adjustments
 
Version 1.4
- several small adjustments

Version 1.3
- removed code that wasn't necessary
- added Hungarian translation (thanks Roman Kekesi)

Version 1.2
- IMPORTANT SECURITY UPDATE > please do not use older version of plugin
- removed jquery validation (and folder .js)
- several other small adjustments

Version 1.1
- removed font-family from stylesheet
- added French and German translation (thanks Curlybracket)

Version 1.0
- first stable release


== Description ==
This is a very simple responsive translation-ready contact form. 

It only contains Name, Email, Subject and Message. And a simple captcha sum. 

Use shortcode [contact] to display form on page or use the widget to display form in sidebar.

You can change the layout (CSS) of your form using the custom style page in WP dashboard.

= Translation =
Dutch, German, French, Danish, Swedish , Italian, Spanish, Catalan, Brazilian Portuguese, Polish, Croatian, Estonian, Slovenian, Hungarian and Turkish translation included. More translations are very welcome! Please contact me via my website.

= Credits =
Without the WordPress codex and help from the WordPress community I was not able to develop this plugin, so: thank you! 
And a special thanks to the friendly users of 'PHP hulp' for helping me to create bugfree code.

I used these scripts for developing the Very Simple Contact Form:

http://code.tutsplus.com/articles/creating-a-simple-contact-form-for-simple-needs--wp-27893

http://code.tutsplus.com/articles/building-custom-wordpress-widgets--wp-25241

These scripts are released under the GNU General Public License v3 or later.

Enjoy,
Guido


== Installation == 
After installation please add shortcode [contact] on your contactpage for displaying the form. 

In this case messages will be send to email from admin (Settings > General).

If you want to use another email, use shortcode [contact email_to="your-email-here"].

And if you want to use multiple email, use shortcode [contact email_to="first-email-here, second-email-here"].

Note: the sidebar widget uses email from admin (Settings > General).


== Frequently Asked Questions ==
= I don't like the form layout, how can I change this? =
Form will use theme styling for input fields and submit button. 

Custom Style editor included: you can change the layout (CSS) of your form using the custom style page in WP dashboard. Max. 2000 characters allowed.

= Why am I not receiving messages? =
1) Look also in your junk/spam folder.

2) Check info about installation and check shortcode for mistakes.

3) Install another contactform plugin to determine if it's caused by Very Simple Contact Form or something else.

4) Messages are send using the wp-mail function, maybe your hostingprovider disabled the php mail function. Ask them to enable it. 

= Can I use multiple forms on the same website? =
Yes and no. Don't use multiple forms on the same website. This may cause a conflict. But you can use the shortcode on your contactpage and the widget on the same website.

= Is my language supported too? =
You can enter all UTF-8 characters, so many languages are supported. But the plugin itself is only translated in several languages. 

= Is this plugin protected against spammers, bots, etc? =
The default WordPress sanitization function is included.

For email field:

http://codex.wordpress.org/Function_Reference/sanitize_email

For other fields:

http://codex.wordpress.org/Function_Reference/sanitize_text_field

It also contains honeypot fields and a simple captcha sum.

= I notice there are 2 invisible fields (firstname and lastname), what's up with that? =
This is part of anti-spam: these are the 2 honeypot fields

= Other question or comment? =
Please open a topic in plugin forum or send me a message via my website.


== Screenshots == 
1. Very Simple Contact Form in frontend (using Twenty Fifteen theme).

2. Very Simple Contact Form in frontend (using Twenty Fifteen theme).

3. Very Simple Contact Form Custom Style editor.
