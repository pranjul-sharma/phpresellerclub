<?php

require_once __DIR__ . '/../core/Core.php';

class Billing extends Core {

  public function getCustomerPricing($customerId) {
    $options = array(
      'customer-id' => $customerId,
    );
    $apiOut = $this->callApi('products', 'customer-price', $options);
  }

  public function getResellerPricing($resellerId) {
    $options = array(
      'reseller-id' => $resellerId,
    );
    $apiOut = $this->callApi('products', 'reseller-price', $options);
  }

  public function getResellerCostPricing($resellerId) {
    $options = array(
      'reseller-id' => $resellerId,
    );
    $apiOut = $this->callApi('products', 'reseller-cost-price', $options);
    return $apiOut;
  }

  public function getCustomerTransactionDetails($transactionIds) {
    // Handles array and string
    $apiOut = $this->callApi('products', 'reseller-cost-price', $transactionIds);
    return $apiOut;
  }

  public function getResellerTransactionDetails($transactionIds) {
    $apiOut = $this->callApi('products', 'reseller-cost-price', $transactionIds);
    return $apiOut;
  }

  public function payTransactions($invoiceIds = NULL, $debitIds = NULL) {
    $options = array(
      'invoice-ids' => $invoiceIds,
      'debit-ids' => $debitIds,
    );
    $apiOut = $this->callApi('billing', 'customer-pay', $options);
    return $apiOut;
  }

  public function cancelInvoiceDebitNote($invoiceIds = NULL, $debitIds = NULL) {
    $options = array(
      'invoice-ids' => $invoiceIds,
      'debit-ids' => $debitIds,
    );
    $apiOut = $this->callApi('billing', 'cancel', $options, 'customer-transactions');
    return $apiOut;
  }

  public function getCustomerBalance($customerId) {
    $options = array(
      'customer-id' => $customerId,
    );
    $apiOut = $this->callApi('billing', 'customer-balance', $options);
    return $apiOut;
  }

  public function executeOrderWithoutPayment($invoiceIds, $cancelInvoice = FALSE) {
    $options = array(
      'invoice-ids' => $invoiceIds,
      'cancel-invoice' => $cancelInvoice,
    );
    $apiOut = $this->callApi('billing', 'execute-order-without-payment', $options);
    return $apiOut;
  }

  public function searchCustomerTransaction($options, $page = 1, $count = 10) {
    $options['no-of-records'] = $count;
    $options['page-no'] = $page;
    $apiOut = $this->callApi('billing', 'search', $options, 'customer-transactions');
    return $apiOut;
  }

  public function searchResellerTransaction($options, $page = 1, $count = 10) {
    $options['no-of-records'] = $count;
    $options['page-no'] = $page;
    $apiOut = $this->callApi('billing', 'search', $options, 'reseller-transactions');
    return $apiOut;
  }

  public function getResellerBalance($resellerId) {
    $options = array(
      'reseller-id' => $resellerId,
    );
    $apiOut = $this->callApi('billing', 'reseller-balance', $options);
    return $apiOut;
  }

  public function discountInvoice($invoiceId, $discount, $transactionKey, $role) {
    $options = array(
      'invoice-id' => $invoiceId,
      'discount-without-tax', $discount,
      'transaction-key' => $transactionKey,
      'role' => $role,
    );
    $apiOut = $this->callApi('billing', 'customer-processdiscount', $options);
    return $apiOut;
  }

  public function addFundsCustomer($customerId, $options) {
    $options['customer-id'] = $customerId;
    $apiOut = $this->callApi('billing', 'add-customer-fund', $options);
    return $apiOut;
  }

  public function addFundsReseller($resellerId, $options) {
    $options['reseller-id'] = $resellerId;
    $apiOut = $this->callApi('billing', 'add-reseller-fund', $options);
    return $apiOut;
  }

  public function addDebitNoteCustomer($customerId, $options) {
    $options['customer-id'] = $customerId;
    $apiOut = $this->callApi('billing', 'add-customer-debit-note', $options);
    return $apiOut;
  }

  public function addDebitNoteReseller($resellerId, $options) {
    $options['reseller-id'] = $resellerId;
    $apiOut = $this->callApi('billing', 'add-reseller-debit-note', $options);
    return $apiOut;
  }

  public function suspendOrder($orderId, $reason) {
    $apiOut = $this->callApi('orders', 'suspend', array(
      'order-id' => $orderId,
      'reason', $reason,
    ));
    return $apiOut;
  }

  public function unsuspendOrder($orderId) {
    $apiOut = $this->callApi('orders', 'unsuspend', array(
      'order-id' => $orderId,
    ));
    return $apiOut;
  }

  public function getCurrentActions($options, $page = 1, $count = 10) {
    $options['no-of-records'] = $count;
    $options['page-no'] = $page;
    $apiOut = $this->callApi('actions', 'search-current', $options);
    return $apiOut;
  }

  public function getArchiveActions($options, $page = 1, $count = 10) {
    $options['no-of-records'] = $count;
    $options['page-no'] = $page;
    $apiOut = $this->callApi('actions', 'search-archived', $options);
    return $apiOut;
  }

  public function getLegalAggrement($type) {
    $apiOut = $this->callApi('commons', 'legal-agreements', array('type' => $type));
    return $apiOut;
  }

  /**
   * Get allowed payment gateway for a customer
   *
   * @param int $customerId Customer ID
   * @param string $paymentType Values can be AddFund or Payment.
   * @return array Parsed output of API call
   */
  public function getAllowedPaymentGatewayCustomer($customerId, $paymentType = NULL) {
    $options['customer-id'] = $customerId;
    if (!empty($paymentType)) {
      $options['payment-type'] = $paymentType;
    }
    $apiOut = $this->callApi('pg', 'allowedlist-for-customer', $options);
    return $apiOut;
  }

  /**
   * Get allowed Payment Gateways
   * @return array Parsed output of API call
   */
  public function getAllowedPaymentGatewayReseller() {
    $apiOut = $this->callApi('pg', 'list-for-reseller', array());
    return $apiOut;
  }

  public function getCurrencyDetails() {
    $apiOut = $this->callApi('currency', 'details', array());
    return $apiOut;
  }

  /**
   * Get list of country
   *
   * @see http://manage.resellerclub.com/kb/answer/1746
   * @return array Parsed output of API call
   */
  public function getCountryList() {
    $apiOut = $this->callApi('country', 'list', array());
    return $apiOut;
  }

  /**
   * Get list of states of a given country
   *
   * @see http://manage.resellerclub.com/kb/answer/1747
   * @param string $countryCode 2 letter country code
   * @return array Parsed output of API call
   */
  public function getStateList($countryCode) {
    $apiOut = $this->callApi('country', 'state-list', array(
      'country-code' => $countryCode,
    ));
    return $apiOut;
  }

}
