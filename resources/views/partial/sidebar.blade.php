<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('IndexSmp') }}" class="nav-link @if(Request::is('IndexSmp') || Request::is('/smp')) active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <!-- master -->
          <li class="nav-item @if(Request::is('master/*')) menu-open @endif">
            <a href="#" class="nav-link @if(Request::is('master/*')) active @endif">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Master
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/master/guru')}}" class="nav-link @if(Request::is('master/guru')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Guru</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/master/kelas')}}" class="nav-link @if(Request::is('master/kelas')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelas</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/master/siswa')}}" class="nav-link @if(Request::is('master/siswa')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Siswa</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item @if(Request::is('master/transaksi/*')) menu-open @endif">
                <a href="#" class="nav-link @if(Request::is('master/transaksi/*')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaksi
                  <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{url('/master/transaksi/pengeluaran')}}" class="nav-link  @if(Request::is('master/transaksi/pengeluaran')) active @endif">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Pengeluaran</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{url('/master/transaksi/pemasukan')}}" class="nav-link  @if(Request::is('master/transaksi/pemasukan')) active @endif">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Pemasukan</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{url('/master/transaksi/siswa')}}" class="nav-link  @if(Request::is('master/transaksi/siswa')) active @endif">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Siswa</p>
                      </a>
                    </li>
                  </ul>
              </li>
            </ul>
          </li>

          <!-- Kelas -->
          <li class="nav-item @if(Request::is('kelas/*')) menu-open @endif">
            <a href="#" class="nav-link @if(Request::is('kelas/*')) active @endif">
              <i class="fas fa-door-open"></i>
              <p>
                Kelas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            @foreach($kelas as $kls)
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{ route('kelasView', ['id' => $kls->id]) }}" class="nav-link @if(Request::is('kelas/'. $kls->id)) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{$kls->kelas}}{{$kls->grade}}</p>
                </a>
              </li>
            </ul>
            @endforeach
          </li>
          <!-- Transaksi -->
          <li class="nav-item @if(Request::is('transaksi/*') || Request::is('transaksisaldo-awal/*')) menu-open @endif">
            <a href="#" class="nav-link @if(Request::is('transaksi/*') || Request::is('transaksisaldo-awal/*')) active @endif">
              <i class="fas fa-money-bill"></i>
              <p>
                Transaksi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a> 
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/transaksi/pengeluaran')}}" class="nav-link @if(Request::is('transaksi/pengeluaran')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengeluaran</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/transaksi/pemasukan')}}" class="nav-link @if(Request::is('transaksi/pemasukan')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemasukan</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('transaksi-siswa') }}" class="nav-link @if(Request::is('transaksi/siswa')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>siswa</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href=" "  class="nav-link @if(Request::is('saldo-awal')) active @endif" data-toggle="modal" data-target="#saldoAwal">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Saldo Awal</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Gaji -->
          <!-- <li class="nav-item">
            <a href="{{ url('/gaji/' . date('Y')) }}" class="nav-link @if(Request::is('gaji') || Request::is('gaji/*')) active @endif">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Gaji
              </p>
            </a>
          </li> -->

          <!-- Bos -->
          <li class="nav-item">
            <a href="{{ route('bosIndex') }}" class="nav-link @if(Request::is('bos') || Request::is('bos/*')) active @endif">
              <i class="nav-icon fas fa-school"></i>
              <!-- <i class="fa-solid fa-building-ngo"></i> -->
              <p>
                BOS
              </p>
            </a>
          </li>

           <!-- Saving -->
           <li class="nav-item">
            <a href="{{ route('savingIndex') }}" class="nav-link @if(Request::is('saving') || Request::is('saving/*')) active @endif">
              <i class="nav-icon fas fa-building"></i>
              <!-- <i class="fa-solid fa-building-columns"></i> -->
              <p>
                Saving
              </p>
            </a>
          </li>

          <!-- SPP -->
          <li class="nav-item">
            <a href="{{ url('/spp/' . $klsForSPP) }}" class="nav-link @if(Request::is('spp') || Request::is('spp/*')) active @endif">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                SPP
              </p>
            </a>
          </li>

          <!-- Report -->
          <li class="nav-item">
            <a href="{{ url('/report')}}" class="nav-link @if(Request::is('repot') || Request::is('report/*')) active @endif">
            <i class="nav-icon fas fa-copy"></i>
              <p>
                Report
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('/pembayaran-siswa')}}" class="nav-link @if(Request::is('pembayaran-siswa') || Request::is('pembayaran-siswa/*')) active @endif">
            <i class="nav-icon fas fa-wallet"></i>
              <p>
                Pembayran Siswa
              </p>
            </a>
          </li>

        </ul>