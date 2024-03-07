<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
	protected $order;

	public function __construct($order)
	{
		parent::__construct();

		$this->order = $order;
	}

	public function getSnapToken()
	{
		$params = [

			'transaction_details' => [
				'order_id' => $this->order->number,
				'gross_amount' => $this->order->total_price,
			],

			'item_details' => [
				[
					'id' => $this->order->id, // primary key produk
					'price' => $this->order->total_price, // harga satuan produk
					'quantity' => 1, // kuantitas pembelian
					'name' => 'Flashdisk Toshiba 32GB', // nama produk
				],
			],
			'customer_details' => [
				// Key `customer_details` dapat diisi dengan data customer yang melakukan order.
				'first_name' => 'Martin Mulyo Syahidin',
				'email' => 'mulyosyahidin95@gmail.com',
				'phone' => '081234567890',
			]
		];

		$snapToken = Snap::getSnapToken($params);



		return $snapToken;
	}
}
