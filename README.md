# google-customer-reviews
Magento integration for Google Customer Reviews

This module adds a Google script block to order success page. So Google shows a message asking to accept participating a survey. It requires affiliation to Google Merchants.

![image](https://cloud.githubusercontent.com/assets/13813964/21123122/de54e0d0-c0bd-11e6-94aa-afc6cb286b5c.png)

Important: Google API requires an estimated delivery date. The date is calculated using the field Estimated Delivery Time in settings. So use a number in that field or a pattern to identify the delivery time in shipping description.

Example:
  * Shipping Description: Fixed rate - 5 days.
  * Pattern: /([0-9]+) days/
