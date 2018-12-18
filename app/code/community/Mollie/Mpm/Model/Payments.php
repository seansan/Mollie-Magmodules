<?php
/**
 * Copyright (c) 2012-2018, Mollie B.V.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH
 * DAMAGE.
 *
 * @category    Mollie
 * @package     Mollie_Mpm
 * @author      Mollie B.V. (info@mollie.nl)
 * @copyright   Copyright (c) 2012-2018 Mollie B.V. (https://www.mollie.nl)
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD-License 2
 */

class Mollie_Mpm_Model_Payments extends Mage_Core_Model_Abstract
{

    /**
     * Mollie Helper
     *
     * @var Mollie_Mpm_Helper_Data
     */
    public $mollieHelper;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->mollieHelper = Mage::helper('mpm');
    }

    /**
     * Constructor.
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('mpm/payments');
    }

    /**
     * @return bool
     */
    public function checkTable()
    {
        $paymentsTable = Mage::getSingleton('core/resource')->getTableName('mollie_payments');
        return (boolean)Mage::getSingleton('core/resource')->getConnection('core_write')->showTableStatus($paymentsTable);
    }

    /**
     * Load Old Payment data by TransactionId.
     *
     * @param $transactionId
     *
     * @return mixed
     */
    public function loadByTransactionId($transactionId)
    {
        if (!$this->checkTable()) {
            return false;
        }

        if ($transaction = $this->load($transactionId, 'transaction_id')) {
            return $transaction->getOrderId();
        }
    }

    /**
     * Load Old Payment Title by TransactionId.
     *
     * @param $orderId
     *
     * @return bool|string
     */
    public function getTitleByOrderId($orderId)
    {
        if (!$this->checkTable()) {
            return false;
        }

        if ($transaction = $this->load($orderId, 'order_id')) {
            return ucfirst($transaction->getMethod());
        }
    }
}