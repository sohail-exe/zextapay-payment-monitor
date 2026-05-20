=== ZextaPay Payment Monitor for WooCommerce ===
Contributors: sultan1515
Tags: woocommerce, payment, stripe, monitoring, gateway
Requires at least: 6.0
Tested up to: 6.9
Stable tag: 1.0.1
Requires PHP: 8.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Monitor WooCommerce payment gateways in real-time. See failed transactions, track revenue at risk and keep your store healthy.

== Description ==

**ZextaPay Payment Monitor for WooCommerce**

When your payment gateway fails, your business stops. ZextaPay monitors your WooCommerce payment gateways and shows you exactly what is happening in real-time.

= FREE Features =
* **Live Dashboard:** See all successful and failed transactions in one place.
* **Revenue at Risk:** See exactly how much money is at risk from failed payments.
* **Error Intelligence:** Human-readable error descriptions — no confusing error codes.
* **Full Transaction History:** All transactions are stored and accessible.
* **Gateway Health:** Monitor your payment gateway success rate.

= STARTER (Premium) =
* Real-time Slack and Telegram alerts on failure.

= GROWTH (Premium) =
* Automatic gateway failover — switches to backup gateway on failure.
* Auto-restore when primary gateway comes back online.

== Installation ==

1. Upload the `zextapay-payment-monitor` folder to `/wp-content/plugins/`
2. Activate through the Plugins menu in WordPress
3. Go to ZextaPay in your admin menu
4. Your payment transactions will start appearing automatically

== Frequently Asked Questions ==

= Does this work with Stripe and PayPal? =
Yes. ZextaPay works with Stripe, PayPal, Square, Authorize.net and any WooCommerce compatible gateway.

= Will this slow down my checkout page? =
No. ZextaPay runs entirely in the background. Zero impact on checkout speed.

= What happens if the plugin is deactivated? =
Your store reverts to normal instantly. Zero risk to your checkout.

= Is my customer data safe? =
Yes. ZextaPay only logs order IDs and amounts. No card details or personal data is ever stored.

= Do I need technical knowledge to set this up? =
No. Install, activate and your transactions will start being monitored automatically.

== Screenshots ==

1. The dashboard showing successful and failed transactions with revenue at risk.

== Changelog ==

= 1.0.1 =
* Removed log retention limit — all transaction logs are now kept permanently.
* Fixed Plugin URI.
* Improved security and caching logic.

= 1.0.0 =
* Initial release.
* Live dashboard with transaction monitoring.
* Revenue at risk tracking.
* Full transaction history.

== Upgrade Notice ==

= 1.0.1 =
Important update. Install to keep all transaction logs permanently.

== External Services ==

This plugin does not connect to any external services in the free version.

The free version only stores transaction data locally in your WordPress database. No data is sent to any third-party service.

Premium versions (Starter and Growth) are available via Freemius and connect to Slack and Telegram for alerts.

== Source Code ==

The unminified source code for the build tools and React dashboard (build/index.js) is available at:
https://github.com/sohail-exe/zextapay-payment-monitor
