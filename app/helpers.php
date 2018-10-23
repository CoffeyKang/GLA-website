<?php
use App\Inventory;

    function InventoryExcelFile(){
        // Generate and return the spreadsheet price 
        Excel::create("InventoryExcelPrice1", function($excel){
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Inventory Report');
            $excel->setCreator('Visual Elements Image Studio Inc')->setCompany('Golden Leaf Automotive Inc.');
            $excel->setDescription('Inventory file');
            //sheet
            $excel->sheet("date('Y-m-d')",function($sheet){
                $details = Inventory::select(['item','descrip',"price",'make','year_from','year_end','cupt','length','height','width','lbs','weight'])->get();
                $sheet->fromModel($details,'0', 'A1', true)->setfitToWidth(true);
                $sheet->cell('C1', function($cell) {$cell->setValue('Price');   });
                $sheet->cell('G1', function($cell) {$cell->setValue('CUFT');   });
                $sheet->cells('A1:L1', function($cells) {
                    $cells->setFont(array(
                        'size'       => '12',
                        'bold'       =>  true,
                        'text-transform'=> 'uppercase'
                    ));
                });
            })->store('XLS', public_path('Excel'));
        });

        Excel::create("InventoryExcelPrice2", function($excel){
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Inventory Report');
            $excel->setCreator('Visual Elements Image Studio Inc')->setCompany('Golden Leaf Automotive Inc.');
            $excel->setDescription('Inventory file');
            //sheet
            $excel->sheet("date('Y-m-d')",function($sheet){
                $details = Inventory::select(['item','descrip',"price2",'make','year_from','year_end','cupt','length','height','width','lbs','weight'])->get();
                $sheet->fromModel($details,'0', 'A1', true)->setfitToWidth(true);
                $sheet->cell('C1', function($cell) {$cell->setValue('Price');   });
                $sheet->cell('G1', function($cell) {$cell->setValue('CUFT');   });
                $sheet->cells('A1:L1', function($cells) {
                    $cells->setFont(array(
                        'size'       => '12',
                        'bold'       =>  true,
                        'text-transform'=> 'uppercase'
                    ));
                });
            })->store('XLS', public_path('Excel'));
        });

        Excel::create("InventoryExcelPrice3", function($excel){
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Inventory Report');
            $excel->setCreator('Visual Elements Image Studio Inc')->setCompany('Golden Leaf Automotive Inc.');
            $excel->setDescription('Inventory file');
            //sheet
            $excel->sheet("date('Y-m-d')",function($sheet){
                $details = Inventory::select(['item','descrip',"price3",'make','year_from','year_end','cupt','length','height','width','lbs','weight'])->get();
                $sheet->fromModel($details,'0', 'A1', true)->setfitToWidth(true);
                $sheet->cell('C1', function($cell) {$cell->setValue('Price');   });
                $sheet->cell('G1', function($cell) {$cell->setValue('CUFT');   });
                $sheet->cells('A1:L1', function($cells) {
                    $cells->setFont(array(
                        'size'       => '12',
                        'bold'       =>  true,
                        'text-transform'=> 'uppercase'
                    ));
                });
            })->store('XLS', public_path('Excel'));
        });

        Excel::create("InventoryExcelPrice4", function($excel){
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Inventory Report');
            $excel->setCreator('Visual Elements Image Studio Inc')->setCompany('Golden Leaf Automotive Inc.');
            $excel->setDescription('Inventory file');
            //sheet
            $excel->sheet("date('Y-m-d')",function($sheet){
                $details = Inventory::select(['item','descrip',"price4",'make','year_from','year_end','cupt','length','height','width','lbs','weight'])->get();
                $sheet->fromModel($details,'0', 'A1', true)->setfitToWidth(true);
                $sheet->cell('C1', function($cell) {$cell->setValue('Price');   });
                $sheet->cell('G1', function($cell) {$cell->setValue('CUFT');   });
                $sheet->cells('A1:L1', function($cells) {
                    $cells->setFont(array(
                        'size'       => '12',
                        'bold'       =>  true,
                        'text-transform'=> 'uppercase'
                    ));
                });
            })->store('XLS', public_path('Excel'));
        });  
    }

    
?>
