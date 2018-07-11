<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Http\Controllers\Behaviors\SpreadSheet;
use Belt\Core\Team;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Writer;

class SpreadsheetTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Controllers\Behaviors\SpreadSheet::spreadsheet
     */
    public function test()
    {

        # spreadsheet (manual headers)
        $items = factory(Team::class, 2)->make()->toArray();
        $params = [
            'filename' => 'teams',
            'format' => 'csv',
            'headers' => ['foo', 'bar'],
        ];
        $controller = new SpreadSheetControllerStub();

        return;

        Excel::shouldReceive('create')->once()->with('teams',
            m::on(function (\Closure $closure) use ($items, $params) {
                $excel = m::mock(LaravelExcelWriter::class);
                $excel->shouldReceive('sheet')->with('sheet',
                    m::on(function (\Closure $closure) use ($items, $params) {
                        $sheet = m::mock(LaravelExcelWorksheet::class);
                        $sheet->shouldReceive('appendRow')->andReturnSelf();
                        $sheet->shouldReceive('disconnectCells')->andReturnSelf();
                        $closure($sheet, $items, $params);
                        return is_callable($closure);
                    })
                );
                $closure($excel, $items, $params);
                return is_callable($closure);
            })
        )->andReturnSelf();

        Excel::shouldReceive('download')->with('csv')->andReturn('');

        $controller->spreadsheet($items, $params);

        # spreadsheet (headers defined by object)
        $params = [
            'filename' => 'teams',
            'format' => 'csv',
            'headers' => true,
        ];
        $controller = new SpreadSheetControllerStub();

        Excel::shouldReceive('create')->once()->with('teams',
            m::on(function (\Closure $closure) use ($items, $params) {
                $excel = m::mock(LaravelExcelWriter::class);
                $excel->shouldReceive('sheet')->with('sheet',
                    m::on(function (\Closure $closure) use ($items, $params) {
                        $sheet = m::mock(LaravelExcelWorksheet::class);
                        $sheet->shouldReceive('appendRow')->once()->with(array_keys($items[0]))->andReturnSelf();
                        $sheet->shouldReceive('appendRow')->once()->with($items[0])->andReturnSelf();
                        $sheet->shouldReceive('appendRow')->once()->with($items[1])->andReturnSelf();
                        $sheet->shouldReceive('disconnectCells')->andReturnSelf();
                        $closure($sheet, $items, $params);
                        return is_callable($closure);
                    })
                );
                $closure($excel, $items, $params);
                return is_callable($closure);
            })
        )->andReturnSelf();

        Excel::shouldReceive('download')->with('csv')->andReturn('');

        $controller->spreadsheet($items, $params);

    }

}

class SpreadSheetControllerStub extends Controller
{
    use SpreadSheet;
}