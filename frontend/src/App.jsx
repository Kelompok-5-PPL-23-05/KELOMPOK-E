import { useState, useEffect } from "react";
import { Routes, Route, useNavigate } from "react-router-dom";
import axios from "axios";
import DaftarSiswa from "./pages/DaftarSiswa";

function PilihKelas() {
  const [kelasList, setKelasList] = useState([]);
  const [selectedKelas, setSelectedKelas] = useState("");
  const navigate = useNavigate();

  useEffect(() => {
    axios.get("http://127.0.0.1:8000/api/kelas")
      .then(res => setKelasList(res.data))
      .catch(err => console.error(err));
  }, []);

  const handlePilihKelas = (e) => {
    setSelectedKelas(e.target.value);
    localStorage.setItem("selectedKelas", e.target.value);
    const nama = kelasList.find(k => k.id_kelas == e.target.value)?.nama_kelas;
    localStorage.setItem("selectedKelasNama", nama);
  };

  const handleLanjut = () => {
    navigate(`/siswa/${selectedKelas}`);
  };

  const selectedNama = kelasList.find(k => k.id_kelas == selectedKelas)?.nama_kelas;

  return (
    <div className="min-h-screen bg-gray-100 flex items-center justify-center">
      <div className="bg-white rounded-2xl shadow-lg p-8 w-full max-w-md">
        <div className="flex items-center gap-3 mb-6">
          <div className="bg-blue-800 text-white rounded-lg px-3 py-1 text-sm font-bold">
            PKBM
          </div>
          <h1 className="text-xl font-bold text-gray-800">E-Rapor PKBM</h1>
        </div>

        <h2 className="text-lg font-semibold text-gray-700 mb-2">Pilih Kelas</h2>
        <p className="text-sm text-gray-400 mb-6">
          Pilih kelas yang Anda ampu untuk mengelola data siswa
        </p>

        <div className="mb-6">
          <label className="block text-sm font-medium text-gray-600 mb-2">Kelas</label>
          <select
            value={selectedKelas}
            onChange={handlePilihKelas}
            className="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="">-- Pilih Kelas --</option>
            {kelasList.map(kelas => (
              <option key={kelas.id_kelas} value={kelas.id_kelas}>
                {kelas.nama_kelas}
              </option>
            ))}
          </select>
        </div>

        {selectedKelas && (
          <div className="bg-blue-50 border border-blue-200 rounded-lg px-4 py-3 flex items-center gap-2 mb-4">
            <span className="text-blue-600 text-sm font-medium">✓ Kelas dipilih:</span>
            <span className="text-blue-800 font-semibold text-sm">{selectedNama}</span>
          </div>
        )}

        {selectedKelas && (
          <button
            onClick={handleLanjut}
            className="w-full bg-blue-800 text-white py-2 rounded-lg text-sm font-medium hover:bg-blue-900 transition"
          >
            Lanjut →
          </button>
        )}
      </div>
    </div>
  );
}

export default function App() {
  return (
    <Routes>
      <Route path="/" element={<PilihKelas />} />
      <Route path="/siswa/:id_kelas" element={<DaftarSiswa />} />
    </Routes>
  );
}