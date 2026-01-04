 <!-- Sidebar -->
 <nav class="navbar-vertical navbar">
     <div class="nav-scroller">
         <!-- Brand logo -->
         @auth
             @if (Auth::user()->role === 'Admin')
                 <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                     <img src="{{ asset('assets/images/brand/logo/logo.png') }}" alt="logo" />
                 </a>
             @elseif(Auth::user()->role === 'Student')
                 <a class="navbar-brand" href="{{ route('student.dashboard') }}">
                     <img src="{{ asset('assets/images/brand/logo/logo.png') }}" alt="logo" />
                 </a>
             @elseif(Auth::user()->role === 'Teacher')
                 <a class="navbar-brand" href="{{ route('teacher.dashboard') }}">
                     <img src="{{ asset('assets/images/brand/logo/logo.png') }}" alt="logo" />
                 </a>
             @endif
         @endauth

         <!-- Navbar nav -->
         <ul class="navbar-nav flex-column" id="sideNavbar">
             @auth
                 @if (Auth::user()->role === 'Admin')
                     <li class="nav-item">
                         <a class="nav-link has-arrow {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"
                             href="{{ route('admin.dashboard') }}">
                             <i data-feather="home" class="nav-icon icon-xs me-2"></i> Dashboard
                         </a>
                     </li>
                 @elseif(Auth::user()->role === 'Student')
                     <li class="nav-item">
                         <a class="nav-link has-arrow {{ Request::routeIs('student.dashboard') ? 'active' : '' }}"
                             href="{{ route('student.dashboard') }}">
                             <i data-feather="home" class="nav-icon icon-xs me-2"></i> Dashboard
                         </a>
                     </li>
                 @elseif(Auth::user()->role === 'Teacher')
                     <li class="nav-item">
                         <a class="nav-link has-arrow {{ Request::routeIs('teacher.dashboard') ? 'active' : '' }}"
                             href="{{ route('teacher.dashboard') }}">
                             <i data-feather="home" class="nav-icon icon-xs me-2"></i> Dashboard
                         </a>
                     </li>
                 @endif
             @endauth

             @if (Auth::user()->role === 'Admin')
                 <li class="nav-item">
                     <a class="nav-link has-arrow {{ Request::routeIs('admin.users.create') || Request::routeIs('admin.users.index') ? 'active' : '' }}"
                         href="" data-bs-toggle="collapse" data-bs-target="#navUsers" aria-expanded="false"
                         aria-controls="navUsers">
                         <i data-feather="user" class="nav-icon icon-xs me-2"></i> Users
                     </a>

                     <div id="navUsers" class="collapse" data-bs-parent="#sideNavbar">
                         <ul class="nav flex-column">
                             <li class="nav-item">
                                 <a class="nav-link {{ Request::routeIs('admin.users.create') ? 'active' : '' }}"
                                     href="{{ route('admin.users.create') }}">
                                     Add User
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a class="nav-link {{ Request::routeIs('admin.users.index') ? 'active' : '' }}"
                                     href="{{ route('admin.users.index') }}">
                                     Manage Users
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link has-arrow {{ Request::routeIs('admin.modules.create') || Request::routeIs('admin.modules.index') ? 'active' : '' }}"
                         href="" data-bs-toggle="collapse" data-bs-target="#navModules" aria-expanded="false"
                         aria-controls="navModules">
                         <i data-feather="terminal" class="nav-icon icon-xs me-2">
                         </i> Modules
                     </a>

                     <div id="navModules" class="collapse" data-bs-parent="#sideNavbar">
                         <ul class="nav flex-column">
                             <li class="nav-item">
                                 <a class="nav-link {{ Request::routeIs('admin.modules.create') ? 'active' : '' }}"
                                     href="{{ route('admin.modules.create') }}">
                                     Add Module
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a class="nav-link {{ Request::routeIs('admin.modules.index') ? 'active' : '' }}"
                                     href="{{ route('admin.modules.index') }}">
                                     Manage Modules
                                 </a>
                             </li>
                         </ul>
                     </div>

                 <li class="nav-item">
                     <a class="nav-link has-arrow {{ Request::routeIs('admin.courses.create') || Request::routeIs('admin.courses.index') ? 'active' : '' }}"
                         href="" data-bs-toggle="collapse" data-bs-target="#navCourses" aria-expanded="false"
                         aria-controls="navCourses">
                         <i data-feather="book" class="nav-icon icon-xs me-2">
                         </i> Courses
                     </a>

                     <div id="navCourses" class="collapse" data-bs-parent="#sideNavbar">
                         <ul class="nav flex-column">
                             <li class="nav-item">
                                 <a class="nav-link {{ Request::routeIs('admin.courses.create') ? 'active' : '' }}"
                                     href="{{ route('admin.courses.create') }}">
                                     Add Course
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a class="nav-link {{ Request::routeIs('admin.courses.index') ? 'active' : '' }}"
                                     href="{{ route('admin.courses.index') }}">
                                     Manage Courses
                                 </a>
                             </li>
                         </ul>
                     </div>

                 </li>

                 <li class="nav-item">
                     <a class="nav-link has-arrow {{ Request::routeIs('admin.achievements.create') || Request::routeIs('admin.achievements.index') ? 'active' : '' }}"
                         href="" data-bs-toggle="collapse" data-bs-target="#navAchievements" aria-expanded="false"
                         aria-controls="navAchievements">
                         <i data-feather="award" class="nav-icon icon-xs me-2">
                         </i> Achievements
                     </a>

                     <div id="navAchievements" class="collapse" data-bs-parent="#sideNavbar">
                         <ul class="nav flex-column">
                             <li class="nav-item">
                                 <a class="nav-link {{ Request::routeIs('admin.achievements.create') ? 'active' : '' }}"
                                     href="{{ route('admin.achievements.create') }}">
                                     Add Achievement
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a class="nav-link {{ Request::routeIs('admin.achievements.index') ? 'active' : '' }}"
                                     href="{{ route('admin.achievements.index') }}">
                                     Manage Achievements
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link has-arrow {{ Request::routeIs('admin.ranks.create') || Request::routeIs('admin.ranks.index') ? 'active' : '' }}"
                         href="" data-bs-toggle="collapse" data-bs-target="#navRanks" aria-expanded="false"
                         aria-controls="navRanks">
                         <i data-feather="gitlab" class="nav-icon icon-xs me-2">
                         </i> Ranks
                     </a>

                     <div id="navRanks" class="collapse" data-bs-parent="#sideNavbar">
                         <ul class="nav flex-column">
                             <li class="nav-item">
                                 <a class="nav-link {{ Request::routeIs('admin.ranks.create') ? 'active' : '' }}"
                                     href="{{ route('admin.ranks.create') }}">
                                     Add Rank
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a class="nav-link {{ Request::routeIs('admin.ranks.index') ? 'active' : '' }}"
                                     href="{{ route('admin.ranks.index') }}">
                                     Manage Ranks
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </li>

             @endif

             @if (Auth::user()->role === 'Student')
                 <li class="nav-item">
                     <a class="nav-link has-arrow {{ Request::routeIs('student.modules') ? 'active' : '' }}"
                         href="{{ route('student.modules') }}">
                         <i data-feather="terminal" class="nav-icon icon-xs me-2"></i> Modules
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link has-arrow {{ Request::routeIs('library.show') ? 'active' : '' }}"
                         href="{{ route('library.show') }}">
                         <i data-feather="book" class="nav-icon icon-xs me-2"></i> Library
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link has-arrow {{ Request::routeIs('student.progress') ? 'active' : '' }}"
                         href="{{ route('student.progress') }}">
                         <i data-feather="award" class="nav-icon icon-xs me-2"></i> Rank Progress
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link has-arrow {{ Request::routeIs('student.quizList') ? 'active' : '' }}"
                         href="{{ route('student.quizList') }}">
                         <i data-feather="edit-2" class="nav-icon icon-xs me-2"></i> Quiz
                     </a>
                 </li>
             @endif

             @if (Auth::user()->role === 'Teacher')

                 <li class="nav-item">
                     <a class="nav-link has-arrow {{ Request::routeIs('teacher.tracking') ? 'active' : '' }}"
                         href="{{ route('teacher.tracking') }}">
                         <i data-feather="user" class="nav-icon icon-xs me-2"></i> Students
                     </a>
                 </li>

                 <li class="nav-item">
                    <a class="nav-link has-arrow {{ Request::routeIs('teacher.quizzes.create') || Request::routeIs('teacher.quizzes.index') ? 'active' : '' }}"
                        href="" data-bs-toggle="collapse" data-bs-target="#navQuizzes" aria-expanded="false"
                        aria-controls="navQuizzes">
                        <i data-feather="edit-2" class="nav-icon icon-xs me-2">
                        </i> Quizzes
                    </a>

                    <div id="navQuizzes" class="collapse" data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('teacher.quizzes.create') ? 'active' : '' }}"
                                    href="{{ route('teacher.quizzes.create') }}">
                                    Add Quiz
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('teacher.quizzes.index') ? 'active' : '' }}"
                                    href="{{ route('teacher.quizzes.index') }}">
                                    Manage Quizzes
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

             @endif


         </ul>

     </div>
 </nav>
