=== ZextaPay Payment Monitor for WooCommerce ===
Contributors: sultan1515
Tags: stripe error, failed payment, woocommerce checkout, payment logs, lost revenue
Requires at least: 6.0
Tested up to: 6.9
Stable tag: 1.0.1
Requires PHP: 8.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Stop losing sales to silent WooCommerce payment failures. Monitor every gateway in real-time, see revenue at risk, and get alerted the moment something breaks.

== Description ==

**Most WooCommerce stores only find out a payment gateway is broken when sales mysteriously drop — or an angry customer complains. By then, the damage is already done.**

ZextaPay monitors every transaction across your WooCommerce payment gateways in real-time and shows you exactly what is happening at checkout — failed payments, revenue at risk, and plain-English error explanations — before a silent outage costs you a day's revenue.

No technical knowledge needed. Install, activate, and your transactions start being monitored automatically. Zero impact on checkout speed.

**Learn more at [zextapay.com](https://zextapay.com/)**

= Free Features =

* **Live Transaction Dashboard** — See every successful and failed payment the moment it happens, across Stripe, PayPal, Square, Authorize.net and any WooCommerce-compatible gateway.
* **Revenue at Risk** — See exactly how much money failed payments are costing you today, this week, and this month — in real dollars, not percentages.
* **Plain-English Error Messages** — "Card declined — insufficient funds," not cryptic gateway codes. Instantly understand why a payment failed without digging through logs.
* **Full Transaction History** — Every transaction is stored and searchable. Nothing ages out.
* **Gateway Health Monitoring** — Track your payment gateway success rate over time and spot degradation before it becomes a full outage.

= Starter — Premium =

* **Real-time Slack alerts** when a payment fails or a gateway goes down
* **Real-time Telegram alerts** — get pinged the second something breaks, not after checking the dashboard

= Growth — Premium =

* **Automatic gateway failover** — when your primary gateway goes down, ZextaPay automatically switches checkout to your backup gateway. Customers never see the outage.
* **Auto-restore** — switches back to your primary gateway automatically once it recovers, with no manual intervention needed.

[Upgrade to Starter or Growth →](https://zextapay.com/#pricing)

== Installation ==

1. Search for "ZextaPay" in your WordPress admin under Plugins → Add New, or upload the `zextapay-payment-monitor` folder to `/wp-content/plugins/`
2. Activate through the Plugins menu in WordPress
3. Go to **ZextaPay** in your admin menu
4. Your payment transactions will start appearing automatically — no configuration required

== Frequently Asked Questions ==

= Does this work with Stripe and PayPal? =

Yes. ZextaPay works with Stripe, PayPal, Square, Authorize.net, and any WooCommerce-compatible payment gateway.

= Will this slow down my checkout page? =

No. ZextaPay runs entirely in the background. It has zero impact on checkout speed or the customer experience.

= Is my customer data safe? =

Yes. ZextaPay only logs order IDs and amounts. No card details or personal data are ever stored.

= Do I need technical knowledge to set this up? =

No. Install, activate, and your transactions start being monitored automatically. No API keys, no code, no configuration required.

= What happens if I deactivate the plugin? =

Your store reverts to normal instantly. Zero risk to your checkout.

= Which payment gateways does it support? =

ZextaPay works with any WooCommerce-compatible gateway. It has been tested with Stripe, PayPal, Square, and Authorize.net.

== Screenshots ==

1. The live transaction dashboard showing successful and failed payments with revenue at risk highlighted.

== Changelog ==

= 1.0.1 =
* Removed log retention limit — all transaction logs are now kept permanently.
* Fixed Plugin URI.
* Improved security and caching logic.

= 1.0.0 =
* Initial release.
* Live dashboard with real-time transaction monitoring.
* Revenue at risk tracking.
* Full transaction history.

== Upgrade Notice ==

= 1.0.1 =
Important update — installs to keep all transaction logs permanently and improves security. Recommended for all users.

== External Services ==

The free version does not connect to any external services. All transaction data is stored locally in your WordPress database. No data is sent to any third-party service.

Premium versions (Starter and Growth) connect to Slack and/or Telegram to deliver real-time payment failure alerts. These connections are opt-in and only activated when you configure your own Slack or Telegram credentials. See the [Slack privacy policy](https://slack.com/privacy-policy) and [Telegram privacy policy](https://telegram.org/privacy).

== Source Code ==

The unminified source code for the build tools and React dashboard (build/index.js) is available at:
https://github.com/sohail-exe/zextapay-payment-monitor
