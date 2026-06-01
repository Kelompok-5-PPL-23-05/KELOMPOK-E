        {{-- ── Flash Messages ── --}}
        @if(session('success'))
            <div style="
                background-color:#d4edda; color:#155724;
                border:1px solid #c3e6cb; border-radius:8px;
                padding:14px 20px; margin-bottom:24px;
                font-size:14px; font-weight:500;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="
                background-color:#f8d7da; color:#721c24;
                border:1px solid #f5c6cb; border-radius:8px;
                padding:14px 20px; margin-bottom:24px;
                font-size:14px; font-weight:500;">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        {{-- ── Filter Form (GET) ── --}}
        <form id="filter-form" method="GET" action="{{ route('dashboard') }}">

            <div class="filter-row">

                {{-- Dropdown Pilih Kelas --}}
                <div class="filter-group">
                    <label for="kelas_id">Pilih Kelas</label>

                    <select
                        id="kelas_id"
                        name="kelas_id"
                        class="filter-select"
                        onchange="document.getElementById('filter-form').submit()">

                        <option value="">— Pilih Kelas —</option>

                        @foreach($kelasList as $kelas)
                            <option
                                value="{{ $kelas->id_kelas }}"
                                {{ $selectedKelas == $kelas->id_kelas ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Dropdown Pilih Mata Pelajaran --}}
                <div class="filter-group">
                    <label for="mapel_id">Pilih Mata Pelajaran</label>

                    <select
                        id="mapel_id"
                        name="mapel_id"
                        class="filter-select"
                        onchange="document.getElementById('filter-form').submit()">

                        <option value="">— Pilih Mata Pelajaran —</option>

                        @foreach($mataPelajaran as $mapel)
                            <option
                                value="{{ $mapel->id_mapel }}"
                                {{ $selectedMapel == $mapel->id_mapel ? 'selected' : '' }}>
                                {{ $mapel->nama_mapel }}
                            </option>
                        @endforeach

                    </select>
                </div>

            </div>

        </form>

        {{-- ── Info heading kelas terpilih ── --}}
        @if($kelasTerpilih)
            <p style="
                font-size:15px;
                font-weight:600;
                margin-bottom:20px;
                color:#2c3e50;">

                Kelas: {{ $kelasTerpilih->nama_kelas }}

                <span style="font-weight:400; color:#555;">
                    ({{ $siswa->count() }} siswa)
                </span>

            </p>
        @endif

        {{-- ── Prompt jika belum pilih kelas ── --}}
        @if(!$selectedKelas)

            <div style="
                background:#fff;
                border-radius:10px;
                padding:48px 24px;
                text-align:center;
                box-shadow:0 2px 6px rgba(0,0,0,0.06);
                color:#888;">

                <svg
                    style="width:48px;height:48px;margin-bottom:12px;opacity:.35;"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21
                           M6.75 6.75h.75m-.75 3h.75m-.75 3h.75
                           m3-6h.75m-.75 3h.75m-.75 3h.75
                           M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25
                           c.621 0 1.125.504 1.125 1.125V21
                           M3 3h12m-.75 4.5H21m-3.75 0h.008v.008h-.008v-.008z"/>
                </svg>

                <p style="font-size:14px;">
                    Silakan pilih kelas terlebih dahulu untuk melihat daftar siswa.
                </p>

            </div>

        {{-- ── Form input nilai ── --}}
        @else

            <form action="{{ route('nilai.store') }}" method="POST">

                @csrf

                <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">
                <input type="hidden" name="mapel_id" value="{{ $selectedMapel }}">

                <div class="student-list">

                    {{-- ── Siswa dari database ── --}}
                    @foreach($siswa as $s)

                    <div class="student-row">

                        <div class="student-name">

                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0
                                       3.75 3.75 0 017.5 0z
                                       M4.501 20.118a7.5 7.5 0 0114.998 0
                                       A17.933 17.933 0 0112 21.75
                                       c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>

                            {{ strtoupper($s->nama_siswa) }}

                        </div>

                        <div class="input-row">

                            <div class="input-group nilai">

                                <label>
                                    Masukkan nilai
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="number"
                                    name="nilai[{{ $s->id_siswa }}]"
                                    class="form-input"
                                    placeholder="1 - 100"
                                    min="1"
                                    max="100"
                                    oninput="batasNilai(this)"
                                    required>

                            </div>

                            <div class="input-group catatan">

                                <label>Catatan</label>

                                <input
                                    type="text"
                                    name="catatan[{{ $s->id_siswa }}]"
                                    class="form-input"
                                    placeholder="Catatan untuk siswa">

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

                <div class="submit-wrapper">

                    <button type="submit" class="btn-submit">
                        Submit
                    </button>

                </div>

            </form>

        @endif