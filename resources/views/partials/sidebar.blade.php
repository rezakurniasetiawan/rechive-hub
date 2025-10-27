   <nav class="side-nav">
       <a href="" class="intro-x flex items-center pl-5 pt-4">
           <img alt="Rechive Hub" class="w-8" src="{{ asset('dist/images/logo.svg') }}">
           <div class="hidden xl:block text-white ml-3">
               <span class="text-lg"> ReChive<span class="font-bold">Hub</span> </span>
               <p class="text-xs text-white opacity-50">Reza & Chelsa Archive Hub</p>
           </div>
       </a>
       <div class="side-nav__devider my-6"></div>
       <ul>
           <li>
               <a href="{{ route('dashboard') }}"
                   class="side-menu  {{ request()->routeIs('dashboard') ? 'side-menu--active' : '' }}">
                   <div class="side-menu__icon"> <i data-feather="home"></i> </div>
                   <div class="side-menu__title"> Dashboard </div>
               </a>
           </li>
           <li>
               <a href="javascript:;"
                   class="side-menu {{ request()->routeIs('finance.*') ? 'side-menu--active side-menu--open' : '' }}">
                   <div class="side-menu__icon"> <i data-feather="box"></i> </div>
                   <div class="side-menu__title"> Finance <i data-feather="chevron-down"
                           class="side-menu__sub-icon"></i> </div>
               </a>
               <ul class="{{ request()->routeIs('finance.*') ? 'side-menu__sub-open' : '' }}">
                   <li>
                       <a href="{{ route('finance.account.index') }}"
                           class="side-menu {{ request()->routeIs('finance.account.*') ? 'side-menu--active' : '' }}">
                           <div class="side-menu__icon"> <i data-feather="dollar-sign"></i> </div>
                           <div class="side-menu__title"> Finance Account </div>
                       </a>
                   </li>
                   <li>
                       <a href="{{ route('finance.category.index') }}"
                           class="side-menu {{ request()->routeIs('finance.category.*') ? 'side-menu--active' : '' }}">
                           <div class="side-menu__icon"> <i data-feather="tag"></i> </div>
                           <div class="side-menu__title"> Finance Categories </div>
                       </a>
                   </li>
                   <li>
                       <a href="{{ route('finance.transaction.index') }}"
                           class="side-menu {{ request()->routeIs('finance.transaction.*') ? 'side-menu--active' : '' }}">
                           <div class="side-menu__icon"> <i data-feather="repeat"></i> </div>
                           <div class="side-menu__title"> Finance Transactions </div>
                       </a>
                   </li>
               </ul>
           </li>
           {{-- 🧑‍💼 Pekerjaan & Proyek --}}
           <li>
               <a href="javascript:;" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="briefcase"></i></div>
                   <div class="side-menu__title">
                       Pekerjaan & Proyek
                       <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                   </div>
               </a>
               <ul class="">
                   <li>
                       <a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="layers"></i></div>
                           <div class="side-menu__title">Daftar Proyek</div>
                       </a>
                   </li>
                   <li>
                       <a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="check-square"></i></div>
                           <div class="side-menu__title">Task Manager</div>
                       </a>
                   </li>
                   <li>
                       <a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="clock"></i></div>
                           <div class="side-menu__title">Log Aktivitas</div>
                       </a>
                   </li>
                   <li>
                       <a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="file-text"></i></div>
                           <div class="side-menu__title">Dokumen Kerja</div>
                       </a>
                   </li>
               </ul>
           </li>

           {{-- 📅 Aktivitas Harian --}}
           <li>
               <a href="javascript:;" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="calendar"></i></div>
                   <div class="side-menu__title">
                       Aktivitas Harian
                       <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                   </div>
               </a>
               <ul class="">
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="calendar"></i></div>
                           <div class="side-menu__title">Agenda</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="activity"></i></div>
                           <div class="side-menu__title">Habit Tracker</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="smile"></i></div>
                           <div class="side-menu__title">Mood Tracker</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="book-open"></i></div>
                           <div class="side-menu__title">Daily Journal</div>
                       </a></li>
               </ul>
           </li>

           {{-- 🗒️ Catatan & Dokumentasi --}}
           <li>
               <a href="javascript:;" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="book"></i></div>
                   <div class="side-menu__title">
                       Catatan & Dokumentasi
                       <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                   </div>
               </a>
               <ul class="">
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="edit-3"></i></div>
                           <div class="side-menu__title">Catatan Umum</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="file"></i></div>
                           <div class="side-menu__title">Dokumen Penting</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="bookmark"></i></div>
                           <div class="side-menu__title">Bookmark</div>
                       </a></li>
               </ul>
           </li>

           {{-- 🎯 Rencana & Tujuan Hidup --}}
           <li>
               <a href="javascript:;" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="target"></i></div>
                   <div class="side-menu__title">
                       Rencana & Tujuan Hidup
                       <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                   </div>
               </a>
               <ul class="">
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="flag"></i></div>
                           <div class="side-menu__title">Goals</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="clock"></i></div>
                           <div class="side-menu__title">Timeline</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="refresh-cw"></i></div>
                           <div class="side-menu__title">Reflection</div>
                       </a></li>
               </ul>
           </li>

           {{-- 💬 Komunikasi --}}
           <li>
               <a href="javascript:;" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="message-circle"></i></div>
                   <div class="side-menu__title">
                       Komunikasi
                       <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                   </div>
               </a>
               <ul class="">
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="share-2"></i></div>
                           <div class="side-menu__title">Shared Notes</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="mail"></i></div>
                           <div class="side-menu__title">Pesan Internal</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="bell"></i></div>
                           <div class="side-menu__title">Reminder Bersama</div>
                       </a></li>
               </ul>
           </li>

           {{-- 🌿 Personal Growth --}}
           <li>
               <a href="javascript:;" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="heart"></i></div>
                   <div class="side-menu__title">
                       Personal Growth
                       <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                   </div>
               </a>
               <ul class="">
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="book-open"></i></div>
                           <div class="side-menu__title">Learning Tracker</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="award"></i></div>
                           <div class="side-menu__title">Skill Progress</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="heart"></i></div>
                           <div class="side-menu__title">Self Reflection</div>
                       </a></li>
               </ul>
           </li>

           {{-- 🌍 Life Management --}}
           <li>
               <a href="javascript:;" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="compass"></i></div>
                   <div class="side-menu__title">
                       Life Management
                       <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                   </div>
               </a>
               <ul class="">
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="calendar"></i></div>
                           <div class="side-menu__title">Life Calendar</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="map"></i></div>
                           <div class="side-menu__title">Vision Map</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="activity"></i></div>
                           <div class="side-menu__title">Life Metrics</div>
                       </a></li>
               </ul>
           </li>

           {{-- 💡 Knowledge Base --}}
           <li>
               <a href="javascript:;" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="archive"></i></div>
                   <div class="side-menu__title">
                       Knowledge Base
                       <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                   </div>
               </a>
               <ul class="">
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="book"></i></div>
                           <div class="side-menu__title">Artikel & Insight</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="youtube"></i></div>
                           <div class="side-menu__title">Video Belajar</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="globe"></i></div>
                           <div class="side-menu__title">Resource Link</div>
                       </a></li>
               </ul>
           </li>

           {{-- 💾 Data Center --}}
           <li>
               <a href="javascript:;" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="database"></i></div>
                   <div class="side-menu__title">
                       Data Center
                       <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                   </div>
               </a>
               <ul class="">
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="folder"></i></div>
                           <div class="side-menu__title">File Storage</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="server"></i></div>
                           <div class="side-menu__title">Server Status</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="activity"></i></div>
                           <div class="side-menu__title">System Monitor</div>
                       </a></li>
               </ul>
           </li>

           {{-- 🧭 Relationship & Social --}}
           <li>
               <a href="javascript:;" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="users"></i></div>
                   <div class="side-menu__title">
                       Relationship & Social
                       <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                   </div>
               </a>
               <ul class="">
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="heart"></i></div>
                           <div class="side-menu__title">People Journal</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="calendar"></i></div>
                           <div class="side-menu__title">Event Planner</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="message-square"></i></div>
                           <div class="side-menu__title">Relationship Notes</div>
                       </a></li>
               </ul>
           </li>

           {{-- 🪙 Financial Insight --}}
           <li>
               <a href="javascript:;" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="bar-chart-2"></i></div>
                   <div class="side-menu__title">
                       Financial Insight
                       <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                   </div>
               </a>
               <ul class="">
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="trending-up"></i></div>
                           <div class="side-menu__title">Wealth Tracker</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="pie-chart"></i></div>
                           <div class="side-menu__title">Budget Analytics</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="target"></i></div>
                           <div class="side-menu__title">Investment Goals</div>
                       </a></li>
               </ul>
           </li>
           {{-- ⚙️ Pengaturan --}}
           <li>
               <a href="javascript:;" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="settings"></i></div>
                   <div class="side-menu__title">
                       Pengaturan
                       <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                   </div>
               </a>
               <ul class="">
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="user"></i></div>
                           <div class="side-menu__title">Profil</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="moon"></i></div>
                           <div class="side-menu__title">Tema</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="database"></i></div>
                           <div class="side-menu__title">Backup</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="shield"></i></div>
                           <div class="side-menu__title">Keamanan</div>
                       </a></li>
                   <li><a href="" class="side-menu">
                           <div class="side-menu__icon"><i data-feather="git-merge"></i></div>
                           <div class="side-menu__title">Integrasi</div>
                       </a></li>
               </ul>
           </li>

           {{-- 🧠 Insight (AI) --}}
           <li>
               <a href="" class="side-menu">
                   <div class="side-menu__icon"><i data-feather="cpu"></i></div>
                   <div class="side-menu__title">Insight (AI)</div>
               </a>
           </li>

           {{-- <li class="side-nav__devider my-6"></li> --}}

       </ul>
   </nav>
