<nav class="side-nav">
    <a href="{{ route('dashboard') }}" class="intro-x flex items-center pl-5 pt-4">
        <img alt="ReChive Hub Logo" class="w-6" src="{{ asset('dist/images/rechive-logo.svg') }}">
        <span class="hidden xl:block text-white text-lg ml-3">
            Re<span class="font-medium text-theme-1">Chive Hub</span>
        </span>
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        <!-- DASHBOARD -->
        <li>
            <a href="{{ route('dashboard') }}"
                class="side-menu {{ request()->routeIs('dashboard') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="home"></i> </div>
                <div class="side-menu__title"> Dashboard </div>
            </a>
        </li>

        <!-- KEUANGAN -->
        <li>
            <a href="javascript:;" class="side-menu {{ request()->routeIs('finance*') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="dollar-sign"></i> </div>
                <div class="side-menu__title">
                    Keuangan
                    <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul class="">
                <li><a href="{{ route('finance.transactions') }}" class="side-menu">
                        <div class="side-menu__title">Transaksi</div>
                    </a></li>
                <li><a href="{{ route('finance.reports') }}" class="side-menu">
                        <div class="side-menu__title">Laporan</div>
                    </a></li>
                <li><a href="{{ route('finance.budget') }}" class="side-menu">
                        <div class="side-menu__title">Anggaran</div>
                    </a></li>
                <li><a href="{{ route('finance.savings') }}" class="side-menu">
                        <div class="side-menu__title">Tabungan & Investasi</div>
                    </a></li>
                <li><a href="{{ route('finance.debt') }}" class="side-menu">
                        <div class="side-menu__title">Utang & Piutang</div>
                    </a></li>
            </ul>
        </li>

        <!-- PEKERJAAN & PROYEK -->
        <li>
            <a href="javascript:;" class="side-menu {{ request()->routeIs('work*') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="briefcase"></i> </div>
                <div class="side-menu__title">
                    Pekerjaan & Proyek
                    <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul>
                <li><a href="{{ route('work.projects') }}" class="side-menu">
                        <div class="side-menu__title">Daftar Proyek</div>
                    </a></li>
                <li><a href="{{ route('work.tasks') }}" class="side-menu">
                        <div class="side-menu__title">Task Manager</div>
                    </a></li>
                <li><a href="{{ route('work.logs') }}" class="side-menu">
                        <div class="side-menu__title">Log Aktivitas</div>
                    </a></li>
                <li><a href="{{ route('work.documents') }}" class="side-menu">
                        <div class="side-menu__title">Dokumen Kerja</div>
                    </a></li>
            </ul>
        </li>

        <!-- AKTIVITAS HARIAN -->
        <li>
            <a href="javascript:;"
                class="side-menu {{ request()->routeIs('activities*') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="calendar"></i> </div>
                <div class="side-menu__title">
                    Aktivitas Harian
                    <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul>
                <li><a href="{{ route('activities.schedule') }}" class="side-menu">
                        <div class="side-menu__title">Jadwal & Agenda</div>
                    </a></li>
                <li><a href="{{ route('activities.habits') }}" class="side-menu">
                        <div class="side-menu__title">Kebiasaan</div>
                    </a></li>
                <li><a href="{{ route('activities.health') }}" class="side-menu">
                        <div class="side-menu__title">Kesehatan</div>
                    </a></li>
            </ul>
        </li>

        <!-- CATATAN & DOKUMENTASI -->
        <li>
            <a href="javascript:;" class="side-menu {{ request()->routeIs('notes*') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="book-open"></i> </div>
                <div class="side-menu__title">
                    Catatan & Dokumentasi
                    <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul>
                <li><a href="{{ route('notes.personal') }}" class="side-menu">
                        <div class="side-menu__title">Catatan Pribadi</div>
                    </a></li>
                <li><a href="{{ route('notes.journal') }}" class="side-menu">
                        <div class="side-menu__title">Jurnal Harian</div>
                    </a></li>
                <li><a href="{{ route('notes.files') }}" class="side-menu">
                        <div class="side-menu__title">File & Arsip</div>
                    </a></li>
            </ul>
        </li>

        <!-- RENCANA HIDUP -->
        <li>
            <a href="javascript:;" class="side-menu {{ request()->routeIs('plans*') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="target"></i> </div>
                <div class="side-menu__title">
                    Rencana Hidup
                    <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul>
                <li><a href="{{ route('plans.shortterm') }}" class="side-menu">
                        <div class="side-menu__title">Rencana Jangka Pendek</div>
                    </a></li>
                <li><a href="{{ route('plans.longterm') }}" class="side-menu">
                        <div class="side-menu__title">Rencana Jangka Panjang</div>
                    </a></li>
                <li><a href="{{ route('plans.bucketlist') }}" class="side-menu">
                        <div class="side-menu__title">Bucket List</div>
                    </a></li>
            </ul>
        </li>

        <!-- KOMUNIKASI -->
        <li>
            <a href="javascript:;"
                class="side-menu {{ request()->routeIs('communication*') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="message-circle"></i> </div>
                <div class="side-menu__title">
                    Komunikasi
                    <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul>
                <li><a href="{{ route('communication.messages') }}" class="side-menu">
                        <div class="side-menu__title">Pesan</div>
                    </a></li>
                <li><a href="{{ route('communication.feedback') }}" class="side-menu">
                        <div class="side-menu__title">Feedback</div>
                    </a></li>
                <li><a href="{{ route('communication.timeline') }}" class="side-menu">
                        <div class="side-menu__title">Timeline</div>
                    </a></li>
            </ul>
        </li>

        <!-- INSIGHT (AI) -->
        <li>
            <a href="{{ route('insight') }}"
                class="side-menu {{ request()->routeIs('insight') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="cpu"></i> </div>
                <div class="side-menu__title"> Insight (AI) </div>
            </a>
        </li>

        <!-- PENGATURAN -->
        <li class="side-nav__devider my-6"></li>
        <li>
            <a href="javascript:;"
                class="side-menu {{ request()->routeIs('settings*') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="settings"></i> </div>
                <div class="side-menu__title">
                    Pengaturan
                    <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul>
                <li><a href="{{ route('settings.account') }}" class="side-menu">
                        <div class="side-menu__title">Akun</div>
                    </a></li>
                <li><a href="{{ route('settings.preferences') }}" class="side-menu">
                        <div class="side-menu__title">Preferensi</div>
                    </a></li>
                <li><a href="{{ route('settings.appearance') }}" class="side-menu">
                        <div class="side-menu__title">Tampilan</div>
                    </a></li>
            </ul>
        </li>
    </ul>
</nav>
