<?php

namespace App\Tests\Commands\Shell\Amazon;

use App\Commands\Shell\Amazon\AmzAllocationReport;
use App\Commands\Shell\Amazon\AmzAllocationReport\HtmlSourceRecord;
use App\Commands\Shell\Amazon\AmzAllocationReport\HtmlSourceRecordCollection;
use App\Commands\Shell\Amazon\AMZShipmentRegistration;
use App\Common\Log;
use Exception;
use Mockery;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use src\Entity\Brand;
use src\Entity\MakerWh;
use src\Entity\PalRecShipping;
use src\Entity\PalSku;
use src\Repository\BrandRepository;
use src\Repository\Interfaces\BrandRepositoryInterface;
use src\Repository\Interfaces\MakerWhRepositoryInterface;
use src\Repository\Interfaces\PalProductRecShippingRepositoryInterface;
use src\Repository\Interfaces\PalRecShippingRepositoryInterface;
use src\Repository\Interfaces\PalSkuRepositoryInterface;
use src\Repository\MakerWhRepository;
use src\Repository\PalProductRecShippingRepository;
use src\Repository\PalRecShippingRepository;
use src\Repository\PalSkuRepository;


class AMZShipmentRegistrationTest extends TestCase
{
    const BRD_ID = 1;
    const ALICE_CODE = 1;
    const FBA_CODE = 1;
    const REQUEST_QUANTITY = 1;
    const REC_SHIP_ID = 1;
    const REC_SHIP_NO = 1;

    private AMZShipmentRegistration $testClass;
    private AMZShipmentRegistration $mockAMZShipmentRegistration;
    private AmzAllocationReport $mockAmzAllocationReport;
    private BrandRepositoryInterface $mockBrandRepository;
    private MakerWhRepositoryInterface $mockMakerWhRepository;
    private PalProductRecShippingRepositoryInterface $mockPalProductRecShippingRepository;
    private PalSkuRepositoryInterface $mockPalSkuRepository;
    private PalRecShippingRepositoryInterface $mockPalRecShippingRepository;

    private PalRecShipping $palRecShipping;
    private Brand $brand;
    private PalSku $palSku;
    private MakerWh $makerWh;

    protected function setUp(): void
    {
        $this->mockAmzAllocationReport = Mockery::mock(AmzAllocationReport::class);
        $this->mockBrandRepository = Mockery::mock(BrandRepository::class);
        $this->mockMakerWhRepository = Mockery::mock(MakerWhRepository::class);
        $this->mockPalProductRecShippingRepository = Mockery::mock(PalProductRecShippingRepository::class);
        $this->mockPalSkuRepository = Mockery::mock(PalSkuRepository::class);
        $this->mockPalRecShippingRepository = Mockery::mock(PalRecShippingRepository::class);
        $this->testClass = new AMZShipmentRegistration(
            Log::getLog() ,
            $this->mockAmzAllocationReport ,
            $this->mockBrandRepository ,
            $this->mockMakerWhRepository ,
            $this->mockPalProductRecShippingRepository ,
            $this->mockPalSkuRepository ,
            $this->mockPalRecShippingRepository ,
        );
        $this->mockAMZShipmentRegistration = Mockery::mock(AMZShipmentRegistration::class ,
            [
                Log::getLog(),
                $this->mockAmzAllocationReport,
                $this->mockBrandRepository,
                $this->mockMakerWhRepository,
                $this->mockPalProductRecShippingRepository,
                $this->mockPalSkuRepository,
                $this->mockPalRecShippingRepository,
            ]
        );

        $this->palRecShipping = PalRecShipping::createByArrayObject([
            'rec_ship_id' => 99,
            'rec_ship_no' => 99,
        ]);
        $this->brand = Brand::createByArrayObject([
            'code_alis' => 99,
            'code_fba' => 99,
        ]);
        $this->palSku = PalSku::createByArrayObject([
            'l_stock_val' =>99,
            'ec_ship_quantity' =>1,
            'rec_ship_id' =>1,
            'ship_no' =>1,
            'mkr_id' =>1,
            'brd_id' =>1,
            'pro_id' =>1,
            'clr_id' =>1,
            'size_id' =>1,
            'ship_qua' =>1,
            'pro_cost_price' =>1,
            'pro_retail_price' =>1,
            'jan' =>1,
            'act_id' =>1,
        ]);
        $this->makerWh = MakerWh::createByArrayObject([
            'mkr_id' => '1',
            'mwh_id' => '1',
            'mwh_cd' => '1',
            'mwh_name' => '1',
            'mwh_post' => '1',
            'mwh_addr1' => '1',
            'mwh_addr2' => '1',
            'mwh_tel' => '1',
            'mwh_other_flg' => '1',
            'mwh_return_flg' => '1',
            'brd_id' => '1',
            'no_disp_flg' => '1',
            'position' => '1',
            'root_flg' => '1',
        ]);
    }
    private function createMockMainResult()
    {
        $mockHtmlSourceRecord = Mockery::mock(HtmlSourceRecord::class);
        $mockHtmlSourceRecord->shouldReceive('requestId')->andReturn('1234-5678-9012-1111');
        $mockHtmlSourceRecord->shouldReceive('merchantSKU')->andReturn('71461235');
        $mockHtmlSourceRecord->shouldReceive('quantity')->andReturn('1');

        $mockHtmlSourceRecordCollection = Mockery::mock(HtmlSourceRecordCollection::class);
        $mockHtmlSourceRecordCollection->shouldReceive('get')->andReturn([$mockHtmlSourceRecord]);

        $mockMainResult = Mockery::mock(AmzAllocationReport::class);
        $mockMainResult->shouldReceive('htmlSourceRecordCollection')
            ->andReturn($mockHtmlSourceRecordCollection);

        return $mockMainResult;
    }


    /**
     * @doesNotPerformAssertions
     */
    public function testMainOneSuccessfulRequest()
    {
        $shipProductObjectArrayList = [
            $this->palSku
        ];

        // Create a partial mock of the AMZShipmentRegistration
        $mockLogger = Mockery::mock(Logger::class);

        // Mock for AmzAllocationReport
        $this->mockAmzAllocationReport->shouldReceive('main')
            ->andReturn($this->createMockMainResult());

        // Specify which methods to mock
        $this->mockAMZShipmentRegistration->shouldReceive('shipEcProductList')->andReturn($shipProductObjectArrayList);
        $this->mockAMZShipmentRegistration->shouldReceive('recShipId')->once()->andReturn(99);

        // Create a partial mock of the BrandRepository and MakerWhRepository
        $this->mockBrandRepository->shouldReceive('findBrandInfoByBrdIdMakerPal')
            ->andReturn($this->brand);

        $this->mockMakerWhRepository->shouldReceive('findByBrdIdMwhCode')
            ->with($this->palSku->brdId() ,$this->brand->codeFba())->andReturn($this->makerWh);

        $this->mockAMZShipmentRegistration->shouldReceive('beginDbTransaction')->once();
        $this->mockAMZShipmentRegistration->shouldReceive('exclusivePalRecShippingLock')->once();
        $this->mockAMZShipmentRegistration->shouldReceive('recShipNo')->withAnyArgs()->once()->andReturn('999999');

        $this->mockPalRecShippingRepository->shouldReceive('insertPalRecShippingFba')
            ->with(
                $this->palRecShipping,
                $this->brand
            )
            ->once()
            ->andReturn(true);

        $this->mockAMZShipmentRegistration->shouldReceive('saveShipDetail')
            ->with($this->palSku ,$this->palRecShipping)
            ->once();
        $this->mockAMZShipmentRegistration->shouldReceive('commitDbTransaction')->once();

        $this->mockAMZShipmentRegistration->shouldReceive('dbRollBack')->never();

        $this->mockAMZShipmentRegistration->shouldReceive('main')->once()->passthru();
        $this->mockAMZShipmentRegistration->main();
        Mockery::close();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testMainShipEcProductListThrowException()
    {
        $shipProductObjectArrayList = [
            $this->palSku
        ];

        // Create a partial mock of the AMZShipmentRegistration
        $mockLogger = Mockery::mock(Logger::class);

        // Mock for AmzAllocationReport
        $this->mockAmzAllocationReport->shouldReceive('main')
            ->andReturn($this->createMockMainResult());

        // Specify which methods to mock
        $this->mockAMZShipmentRegistration->shouldReceive('shipEcProductList')->andReturn($shipProductObjectArrayList);

        // Specify which methods to mock
        $this->mockAMZShipmentRegistration->shouldReceive('shipEcProductList')->andThrow(new Exception("shipEcProductList() を実行中になんらかの例外発生"));

        $this->mockAMZShipmentRegistration->shouldReceive('commitDbTransaction')->never();
        $this->mockAMZShipmentRegistration->shouldReceive('main')->once()->passthru();
        $this->mockAMZShipmentRegistration->main();
        Mockery::close();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testMainSaveDBException()
    {
        $shipProductObjectArrayList = [
            $this->palSku
        ];

        // Create a partial mock of the AMZShipmentRegistration
        $mockLogger = Mockery::mock(Logger::class);

        // Mock for AmzAllocationReport
        $this->mockAmzAllocationReport->shouldReceive('main')
            ->andReturn($this->createMockMainResult());

        // Specify which methods to mock
        $this->mockAMZShipmentRegistration->shouldReceive('shipEcProductList')->andReturn($shipProductObjectArrayList);
        $this->mockAMZShipmentRegistration->shouldReceive('recShipId')->once()->andReturn(99);

        // Create a partial mock of the BrandRepository and MakerWhRepository
        $this->mockBrandRepository->shouldReceive('findBrandInfoByBrdIdMakerPal')
            ->andReturn($this->brand);

        $this->mockMakerWhRepository->shouldReceive('findByBrdIdMwhCode')
            ->with($this->palSku->brdId() ,$this->brand->codeFba())->andReturn($this->makerWh);

        $this->mockAMZShipmentRegistration->shouldReceive('beginDbTransaction')->once();
        $this->mockAMZShipmentRegistration->shouldReceive('exclusivePalRecShippingLock')->once();
        $this->mockAMZShipmentRegistration->shouldReceive('recShipNo')->withAnyArgs()->once()->andReturn('999999');

        $this->mockPalRecShippingRepository->shouldReceive('insertPalRecShippingFba')
            ->with(
                $this->palRecShipping,
                $this->brand
            )
            ->once()
            ->andReturn(true);

        $this->mockAMZShipmentRegistration->shouldReceive('dbRollBack')->once();

        $this->mockAMZShipmentRegistration->shouldReceive('commitDbTransaction')->never();

        $this->mockAMZShipmentRegistration->shouldReceive('main')->once()->passthru();
        $this->mockAMZShipmentRegistration->main();
        Mockery::close();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testMainIsNotFoundRecShipNo()
    {
        $shipProductObjectArrayList = [
            [
                'l_stock_val' =>99,
                'ec_ship_quantity' =>1,
                'rec_ship_id' =>1,
                'ship_no' =>1,
                'mkr_id' =>1,
                'brd_id' =>1,
                'pro_id' =>1,
                'clr_id' =>1,
                'size_id' =>1,
                'ship_qua' =>1,
                'pro_cost_price' =>1,
                'pro_retail_price' =>1,
                'jan' =>1,
                'act_id' =>1,
            ]
        ];


        // Create a partial mock of the AMZShipmentRegistration
        $mockLogger = Mockery::mock(Logger::class);

        // Mock for AmzAllocationReport
        $this->mockAmzAllocationReport->shouldReceive('main')
            ->andReturn($this->createMockMainResult());

        $this->mockPalRecShippingRepository->shouldReceive('insertPalRecShippingFba')
            ->with(1 ,99 ,'999999' ,99 ,99)
            ->andReturn(1);

        $mockAMZShipmentRegistration = Mockery::mock(AMZShipmentRegistration::class,
            [ $mockLogger ,$this->mockAmzAllocationReport ,$this->mockPalSkuRepository ,$this->mockPalRecShippingRepository]);

        // Specify which methods to mock
        $mockAMZShipmentRegistration->shouldReceive('shipEcProductList')->andReturn($shipProductObjectArrayList);
        $mockAMZShipmentRegistration->shouldReceive('recShipId')->once()->andReturn(99);

        // Create a partial mock of the BrandRepository and MakerWhRepository
        $mockBrand = Mockery::mock('overload:' . Brand::class);
        $mockBrand->shouldReceive('findBrandInfoByBrdIdMakerPal')
            ->andReturn(['code_fba' => 99, 'code_alis' => 99]);
        $mockMakerWhList = Mockery::mock('overload:' . MakerWh::class);
        $makerWhEntity = MakerWhEntity::create(
            [
                'mkr_id' => '1',
                'mwh_id' => '1',
                'mwh_cd' => '1',
                'mwh_name' => '1',
                'mwh_post' => '1',
                'mwh_addr1' => '1',
                'mwh_addr2' => '1',
                'mwh_tel' => '1',
                'mwh_other_flg' => '1',
                'mwh_return_flg' => '1',
                'brd_id' => '1',
                'no_disp_flg' => '1',
                'position' => '1',
                'root_flg' => '1',
            ]
        );

        $mockMakerWhList->shouldReceive('create')->andReturn($mockMakerWhList);
        $mockMakerWhList->shouldReceive('findByBrdIdMwhCode')->with(1, 99)->andReturn([$makerWhEntity]);

        $mockAMZShipmentRegistration->shouldReceive('beginDbTransaction')->once();
        $mockAMZShipmentRegistration->shouldReceive('exclusivePalRecShippingLock')->once();
        $mockAMZShipmentRegistration->shouldReceive('recShipNo')->withAnyArgs()->once()->andReturn(null);
        $mockAMZShipmentRegistration->shouldReceive('vacantShipNo')->once()->andReturn('999999');

        $mockAMZShipmentRegistration->shouldReceive('commitDbTransaction')->never();
        $mockAMZShipmentRegistration->shouldReceive('dbRollBack')->once();

        $mockAMZShipmentRegistration->shouldReceive('main')->once()->passthru();
        $mockAMZShipmentRegistration->main();
        Mockery::close();
    }


    public function testShipEcProductListThrowsDBErrorException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("DBエラーのため処理を強制終了します");

        $this->mockAmzAllocationReport->shouldReceive('main')
            ->andReturn($this->createMockMainResult());

        $this->mockPalSkuRepository->shouldReceive('findSkuByMkrSku')->andReturn(false);
        $this->testClass->shipEcProductList();
    }

    public function testShipEcProductListThrowsNotFoundSkuException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("SKUが存在しません");

        $this->mockAmzAllocationReport->shouldReceive('main')
            ->andReturn($this->createMockMainResult());

        $this->mockPalSkuRepository->shouldReceive('findSkuByMkrSku')->with('71461235')->andReturn([]);
        $this->testClass->shipEcProductList();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testShipEcProductListStockZero()
    {
        $palSkuArrayObject = [
            'mkr_id' => 2,
            'brd_id' => 380,
            'l_stock_val' => 0
        ];

        $mockLogger = Mockery::mock(Logger::class);

        // Mock for the object returned by htmlSourceRecord()
        $mockHtmlSourceRecord = Mockery::mock(HtmlSourceRecord::class);
        $mockHtmlSourceRecord->shouldReceive('requestId')->andReturn('1234-5678-9012-1111');
        $mockHtmlSourceRecord->shouldReceive('merchantSKU')->andReturn('71461235');
        $mockHtmlSourceRecord->shouldReceive('quantity')->andReturn('1');

        // Mock for the object returned by htmlSourceRecordCollection()
        $mockHtmlSourceRecordCollection = Mockery::mock(HtmlSourceRecordCollection::class);
        $mockHtmlSourceRecordCollection->shouldReceive('get')->andReturn([$mockHtmlSourceRecord]);

        // Mock for the object returned by main()
        $mockMainResult = Mockery::mock(AmzAllocationReport::class);
        $mockMainResult->shouldReceive('htmlSourceRecordCollection')
            ->andReturn($mockHtmlSourceRecordCollection);

        // Mock for AmzAllocationReport

        $this->mockAmzAllocationReport->shouldReceive('main')
            ->andReturn($mockMainResult);

        $this->mockPalSkuRepository->shouldReceive('findSkuByMkrSku')->with($mockHtmlSourceRecord->merchantSKU())->andReturn($palSkuArrayObject);

        $mockAMZShipmentRegistration = Mockery::mock(AMZShipmentRegistration::class,
            [  $mockLogger,$this->mockAmzAllocationReport ,$this->mockPalSkuRepository ,$this->mockPalRecShippingRepository]);

        $mockAMZShipmentRegistration->shouldReceive('addShipEcProduct')
            ->never();

        $mockAMZShipmentRegistration->shouldReceive('errorLog')
            ->with('在庫が０となっております');


        $mockAMZShipmentRegistration->shouldReceive('shipEcProductList')->once()->passthru();
        $mockAMZShipmentRegistration->shipEcProductList();
        Mockery::close();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testShipEcProductListShipQuantityZero()
    {
        $palSkuArrayObject = [
            'mkr_id' => 2,
            'brd_id' => 380,
            'l_stock_val' => 99
        ];

        $mockLogger = Mockery::mock(Logger::class);

        // Mock for the object returned by htmlSourceRecord()
        $mockHtmlSourceRecord = Mockery::mock(HtmlSourceRecord::class);
        $mockHtmlSourceRecord->shouldReceive('requestId')->andReturn('1234-5678-9012-1111');
        $mockHtmlSourceRecord->shouldReceive('merchantSKU')->andReturn('71461235');
        $mockHtmlSourceRecord->shouldReceive('quantity')->andReturn('0');

        // Mock for the object returned by htmlSourceRecordCollection()
        $mockHtmlSourceRecordCollection = Mockery::mock(HtmlSourceRecordCollection::class);
        $mockHtmlSourceRecordCollection->shouldReceive('get')->andReturn([$mockHtmlSourceRecord]);

        // Mock for the object returned by main()
        $mockMainResult = Mockery::mock(AmzAllocationReport::class);
        $mockMainResult->shouldReceive('htmlSourceRecordCollection')
            ->andReturn($mockHtmlSourceRecordCollection);

        // Mock for AmzAllocationReport

        $this->mockAmzAllocationReport->shouldReceive('main')
            ->andReturn($mockMainResult);

        $this->mockPalSkuRepository->shouldReceive('findSkuByMkrSku')->with($mockHtmlSourceRecord->merchantSKU())->andReturn($palSkuArrayObject);

        $mockAMZShipmentRegistration = Mockery::mock(AMZShipmentRegistration::class,
            [  $mockLogger,$this->mockAmzAllocationReport ,$this->mockPalSkuRepository ,$this->mockPalRecShippingRepository]);

        $mockAMZShipmentRegistration->shouldReceive('addShipEcProduct')
            ->never();

        $mockAMZShipmentRegistration->shouldReceive('errorLog')
            ->with('出荷数が０となっております');

        $mockAMZShipmentRegistration->shouldReceive('quantityAllocatedFromEC')
            ->with($mockHtmlSourceRecord->quantity() ,$palSkuArrayObject['l_stock_val']);

        $mockAMZShipmentRegistration->shouldReceive('shipEcProductList')->once()->passthru();
        $mockAMZShipmentRegistration->shipEcProductList();
        Mockery::close();
    }

    public function testSaveDetailUnmatch()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("引き当て情報と一致する在庫が PAL_SKUテーブルに存在しません");

        $_SERVER['REQUEST_URI'] = '/some-uri';

        $shipProductObjectArray = [
            'l_stock_val' =>99,
            'ec_ship_quantity' =>1,
            'rec_ship_id' =>1,
            'ship_no' =>1,
            'mkr_id' =>1,
            'brd_id' =>1,
            'pro_id' =>1,
            'clr_id' =>1,
            'size_id' =>1,
            'ship_qua' =>1,
            'pro_cost_price' =>1,
            'pro_retail_price' =>1,
            'jan' =>1,
            'act_id' =>1,
        ];

        // Mock for the object returned by htmlSourceRecord()
        $mockPalSku = Mockery::mock(PalSku::class);
        $mockPalSku->shouldReceive('findByShipProduct')
            ->with($shipProductObjectArray)
            ->andReturn([]);


        $this->testClass->saveShipDetail($shipProductObjectArray,99 ,'999999');
    }



    /**
     * @doesNotPerformAssertions
     */
    public function testMainTransactionRollback()
    {
        $shipProductObjectArrayList = [
            [
                'l_stock_val' =>99,
                'ec_ship_quantity' =>1,
                'rec_ship_id' =>1,
                'ship_no' =>1,
                'mkr_id' =>1,
                'brd_id' =>1,
                'pro_id' =>1,
                'clr_id' =>1,
                'size_id' =>1,
                'ship_qua' =>1,
                'pro_cost_price' =>1,
                'pro_retail_price' =>1,
                'jan' =>1,
                'act_id' =>1,
            ]
        ];


        // Create a partial mock of the AMZShipmentRegistration
        $mockLogger = Mockery::mock(Logger::class);
        $mockLogger->shouldReceive('info');

        $this->mockPalRecShippingRepository->shouldReceive('insertPalRecShippingFba')
            ->with(1 ,99 ,'999999' ,99 ,99)
            ->andReturn(1);

        $mockAMZShipmentRegistration = Mockery::mock(AMZShipmentRegistration::class,
            [ $mockLogger ,$this->mockAmzAllocationReport ,$this->mockPalSkuRepository ,$this->mockPalRecShippingRepository]);

        // Specify which methods to mock
        $mockAMZShipmentRegistration->shouldReceive('shipEcProductList')->andReturn($shipProductObjectArrayList);
        $mockAMZShipmentRegistration->shouldReceive('recShipId')->once()->andReturn(99);

        $mockAMZShipmentRegistration->shouldReceive('beginDbTransaction')->once();
        $mockAMZShipmentRegistration->shouldReceive('exclusivePalRecShippingLock')->once();
        $mockAMZShipmentRegistration->shouldReceive('recShipNo')->withAnyArgs()->once()->andReturn('999999');

        $mockAMZShipmentRegistration->shouldReceive('saveShipDetail')->andThrow(new Exception("Repositoryの中でなんらかのエラーあり"));
        $mockAMZShipmentRegistration->shouldReceive('commitDbTransaction')->never();

        $mockAMZShipmentRegistration->shouldReceive('dbRollBack')->once();

        $mockAMZShipmentRegistration->shouldReceive('errorLog')
            ->with('Repositoryの中でなんらかのエラーあり');


        // Create a partial mock of the BrandRepository and MakerWhRepository
        $mockBrand = Mockery::mock('overload:' . Brand::class);
        $mockBrand->shouldReceive('findBrandInfoByBrdIdMakerPal')
            ->andReturn(['code_fba' => 99, 'code_alis' => 99]);
        $mockMakerWh = Mockery::mock('overload:' . MakerWh::class);
        $makerWhEntity = MakerWhEntity::create(
            [
                'mkr_id' => '1',
                'mwh_id' => '1',
                'mwh_cd' => '1',
                'mwh_name' => '1',
                'mwh_post' => '1',
                'mwh_addr1' => '1',
                'mwh_addr2' => '1',
                'mwh_tel' => '1',
                'mwh_other_flg' => '1',
                'mwh_return_flg' => '1',
                'brd_id' => '1',
                'no_disp_flg' => '1',
                'position' => '1',
                'root_flg' => '1',
            ]
        );
        // Specify the return values
        $mockBrand->shouldReceive('findBrandInfoByBrdIdMakerPal')->with($shipProductObjectArrayList[0]['brd_id'])->andReturn(['code_fba' => 99]);

        $mockMakerWh->shouldReceive('create')->andReturn($mockMakerWh);
        $mockMakerWh->shouldReceive('findByBrdIdMwhCode')->with($shipProductObjectArrayList[0]['brd_id'], 99)->andReturn([$makerWhEntity]);

        $mockAMZShipmentRegistration->shouldReceive('main')->once()->passthru();
        $mockAMZShipmentRegistration->main();
        Mockery::close();
    }


    public function testIsNotDuplicatedShipNo() :void
    {
        $mockLogger = Mockery::mock(Logger::class);
        $mockLogger->shouldReceive('info');

        $this->mockPalRecShippingRepository->shouldReceive('findPalRecShippingByPeriod')
            ->withAnyArgs()
            ->andReturn(null);
        $this->mockPalRecShippingRepository->shouldReceive('findNewRecShipNo')
            ->never();

        $mockAMZShipmentRegistration = Mockery::mock(AMZShipmentRegistration::class,
            [  $mockLogger,$this->mockAmzAllocationReport ,$this->mockPalSkuRepository ,$this->mockPalRecShippingRepository]);

        $mockAMZShipmentRegistration->shouldReceive('isNotDuplicatedPalRecShipping')
            ->withAnyArgs()
            ->andReturn(true);

        $mockAMZShipmentRegistration->shouldReceive('recShipNo')->once()->passthru();
        $result = $mockAMZShipmentRegistration->recShipNo(111111);
        $this->assertIsString($result);
    }

    public function testIsDuplicatedShipNo() :void
    {
        $mockLogger = Mockery::mock(Logger::class);
        $mockLogger->shouldReceive('info');

        $this->mockPalRecShippingRepository->shouldReceive('findPalRecShippingByPeriod')
            ->withAnyArgs()
            ->andReturn(null);
        $this->mockPalRecShippingRepository->shouldReceive('findNewRecShipNo')
            ->once()
            ->with('70')
            ->andReturn('70999999');

        $mockAMZShipmentRegistration = Mockery::mock(AMZShipmentRegistration::class,
            [  $mockLogger,$this->mockAmzAllocationReport ,$this->mockPalSkuRepository ,$this->mockPalRecShippingRepository]);

        $mockAMZShipmentRegistration->shouldReceive('isNotDuplicatedPalRecShipping')
            ->withAnyArgs()
            ->andReturn(false);

        $mockAMZShipmentRegistration->shouldReceive('recShipNo')->once()->passthru();
        $result = $mockAMZShipmentRegistration->recShipNo('999999');
        $this->assertIsString($result);
    }


    protected function tearDown(): void
    {
        Mockery::close();
    }
}