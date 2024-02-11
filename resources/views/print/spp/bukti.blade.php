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
            
      
        <span style="font-size:28;">SPP {{$spp->name}} Bulan {{$spp->bulan}} <br> {{$spp->tahun}}</span>
        <br>
        <span style="font-size:22;">Rp. {{ number_format($spp->jumlah, 2, ',', '.') }}</span>
                <h3 style="margin: 20px;">Bukti</h3>
                <img src="{{ asset('/uploads/spp/' . $spp->bukti) }}" alt=""  width="200" height="200">

              
              
               
            
          
            
        
            <p style="font-size: 13px;font-weight: bold">
                                  
            </p>
            <p style="font-size: 13px;"></p>
            

        </div>
    </div>
    <div style="display:block; page-break-before:always;"></div>
