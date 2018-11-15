<?php
use App\Inventory;
use App\SOMAST;
use App\AddressBook;
use App\Billing;
use App\User;
use Mail;
use App\Mail\registration;
use App\Mail\SalesOrder;

    function InventoryExcelFile(){
        // Generate and return the spreadsheet price 
        Excel::create("InventoryExcelPrice1", function($excel){
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Inventory Report');
            $excel->setCreator('Visual Elements Image Studio Inc')->setCompany('Golden Leaf Automotive Inc.');
            $excel->setDescription('Inventory file');
            //sheet
            $excel->sheet("date('Y-m-d')",function($sheet){
                $details = Inventory::select(['item','descrip',"price",'make','year_from','year_end','length','height','width','lbs'])->get();
                $sheet->fromModel($details,'0', 'A1', true)->setfitToWidth(true);
                $sheet->cell('C1', function($cell) {$cell->setValue('Price');   });
                $sheet->cells('A1:J1', function($cells) {
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
                $details = Inventory::select(['item','descrip',"price2",'make','year_from','year_end','length','height','width','lbs'])->get();
                $sheet->fromModel($details,'0', 'A1', true)->setfitToWidth(true);
                $sheet->cell('C1', function($cell) {$cell->setValue('Price');   });
                
                $sheet->cells('A1:J1', function($cells) {
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
                $details = Inventory::select(['item','descrip',"price3",'make','year_from','year_end','length','height','width','lbs'])->get();
                $sheet->fromModel($details,'0', 'A1', true)->setfitToWidth(true);
                $sheet->cell('C1', function($cell) {$cell->setValue('Price');   });
                
                $sheet->cells('A1:J1', function($cells) {
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
                $details = Inventory::select(['item','descrip',"price4",'make','year_from','year_end','length','height','width','lbs'])->get();
                $sheet->fromModel($details,'0', 'A1', true)->setfitToWidth(true);
                $sheet->cell('C1', function($cell) {$cell->setValue('Price');   });
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

    function soSendemail(SOMAST $somast){
        
        $user = $somast->customer;

        $billing = $user->BillingAddress;

        $add_id = $somast->address;

        if (!$add_id==0) {
            $address = AddressBook::find($add_id);
        }else{
            $address =AddressBook::find(1);
        }

        Mail::to("$user->email")->send(new SalesOrder($user,$somast,$billing,$address));
        
    }

    
?>
