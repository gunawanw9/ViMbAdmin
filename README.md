# Postfix Address Rewriting
## Postfix Canonical Address Mapping

When you have to send email from specific sender@domain in your Virtual Map or relaying the sender@domain **But** it is already exist in **Aliases** table, so you **can not** create mailbox with the same address. The solution is rewriting sender address and you just have to use the right nickname of the sender@domain address for your existing mailbox account.

For example:
Your mailbox account: test@domain.com
Your aliases account: support@domain.com
Put entry in canonical: support@domain.com for test@domain.com

Then setup your identity or nickname on your MUA as "Support" for sender address support@domain.com.

**This situation might be happened when you setup aliases account for group mail distribution and you need to send email to them with sender address as aliases account.**

Good luck!

# ViMbAdmin
## Virtual Mailbox Administration

The **ViMbAdmin** project (*vim-be-admin*) provides a web based virtual mailbox administration system to allow mail administrators to easily manage domains, mailboxes and aliases.

**ViMbAdmin** was written in PHP using our own web application framework which includes the Zend Framework, the Doctrine ORM and the Smarty templating system with JQuery and Bootstrap.



* [Homepage](http://www.vimbadmin.net/)
* [Documentation](https://github.com/opensolutions/ViMbAdmin/wiki)
* [Vagrant](https://github.com/opensolutions/ViMbAdmin/wiki/Vagrant)
* [Releases](https://github.com/opensolutions/ViMbAdmin/releases)
* [Support](http://www.vimbadmin.net/support.php)
* [Screenshots](http://www.vimbadmin.net/screenshots.php)
* [Live Demo](http://www.vimbadmin.net/demo)
* [Packagist / Composer](https://packagist.org/packages/opensolutions/vimbadmin)
* [Discussion Mailing List](http://groups.google.com/group/vimbadmin-discuss)
* [Announcement Mailing List](http://groups.google.com/group/vimbadmin-announce)
* [Latest News](http://www.barryodonovan.com/tag/vimbadmin) ([RSS feed](http://www.barryodonovan.com/tag/vimbadmin/feed/))
