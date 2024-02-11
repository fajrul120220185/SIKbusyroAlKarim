<style>
    body {
        color: #000;
        background: #fff;
        font-size: 11px;
    }
    table, th, tr, td {
        font-size: 20px;
    }
 
</style>
<div style="margin: 20px 0">
        <div style="text-align: center;margin: 0 auto;">
            
      
        <span style="font-size:28;">Pembayaran {{$transaksi->trans_name}} <br> {{$transaksi->siswa_name}}</span>
        <br>
                <h3 style="margin: 20px;">Bukti</h3>
                @foreach($bukti as $bkt)
                <img src="{{ asset('/uploads/transaksiSiswa/' . $bkt->bukti) }}" alt=""  width="200" height="200">
                @endforeach

              
              
               
            
          
            
        
            <p style="font-size: 13px;font-weight: bold">
                                  
            </p>
            <p style="font-size: 13px;">
                
                </p>
            

        </div>
    </div>
    <div style="display:block; page-break-before:always;"></div>
