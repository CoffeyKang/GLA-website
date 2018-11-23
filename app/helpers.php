<?php
use App\Inventory;
use App\SOMAST;
use App\AddressBook;
use App\Billing;
use App\User;
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

    function SO_PDF($sono){
        
        $history = SOMAST::where('order_num',$sono)->first();
        $customer = $history->customer;
        $billing = $customer->BillingAddress;
        $userInfo = $customer->userDetails;
        $oneOrder = $history->sotran;
        if ($history) {
            
            $oneOrder = $history->sotran()->get();

            foreach ($oneOrder as $item) {
                $iteminfo = $item->itemInfo()->first()->allMakes();
                $item->make = $iteminfo->all_makes;
                $item->descrip = $item->itemInfo->descrip;
            }

            $address = $history->address;
            if ($address==0) {
                $pdf = PDF::loadView('pdf.salesorder', 
                ['somast'=>$history, 'oneOrder'=>$oneOrder, 
                'status'=>'valid','address'=>0,'billing'=>$billing,
                'userInfo'=>$userInfo,'oneOrder'=>$oneOrder]);
                
            }else{
                $addressBook = AddressBook::find($address);
                $pdf = PDF::loadView('pdf.salesorder', 
                ['somast'=>$history, 'oneOrder'=>$oneOrder, 'status'=>'valid','address'=>$addressBook,'billing'=>$billing,
                'userInfo'=>$userInfo,'oneOrder'=>$oneOrder]);
                
            }
            
            return $pdf->setPaper('a4')->save("PDF/salesOrder/$sono.pdf")->stream('download.pdf');
        }else{
           
        }

        function test($sono){
            
        }
       
    }

    
?>
