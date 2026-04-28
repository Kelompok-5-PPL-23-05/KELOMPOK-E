import { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import axios from "axios";

export default function DaftarSiswa() {
  const { id_kelas } = useParams();
  const navigate = useNavigate();
  const [siswaList, setSiswaList] = useState([]);
  const [namaKelas, setNamaKelas] = useState("");
  const [loading, setLoading] = useState(true);
  const [editSiswa, setEditSiswa] = useState(null);
  const [editNama, setEditNama] = useState("");
  const [toast, setToast] = useState(null);

  useEffect(() => {
    const savedNama = localStorage.getItem("selectedKelasNama");
    if (savedNama) setNamaKelas(savedNama);

    fetchSiswa();
  }, [id_kelas]);

  const fetchSiswa = () => {
    axios.get(`http://127.0.0.1:8000/api/siswa/${id_kelas}`)
      .then(res => {
        setSiswaList(res.data);
        setLoading(false);
      })
      .catch(() => {
        setSiswaList([]);
        setLoading(false);
      });
  };

  const showToast = (msg, type = "success") => {
    setToast({ msg, type });
    setTimeout(() => setToast(null), 3000);
  };

  const handleEdit = (siswa) => {
    setEditSiswa(siswa);
    setEditNama(siswa.nama_siswa);
  };

  const handleSaveEdit = () => {
    axios.put(`http://127.0.0.1:8000/api/siswa/${editSiswa.id_siswa}`, {
      nama_siswa: editNama
    })
      .then(() => {
        setSiswaList(prev => prev.map(s =>
          s.id_siswa === editSiswa.id_siswa ? { ...s, nama_siswa: editNama } : s
        ));
        setEditSiswa(null);
        showToast("Data siswa berhasil diupdate!");
      })
      .catch(() => showToast("Gagal mengupdate data!", "error"));
  };

  const handleHapus = (id_siswa, nama) => {
    if (!confirm(`Hapus siswa "${nama}"?`)) return;

    axios.delete(`http://127.0.0.1:8000/api/siswa/${id_siswa}`)
      .then(() => {
        setSiswaList(prev => prev.filter(s => s.id_siswa !== id_siswa));
        showToast("Siswa berhasil dihapus!");
      })
      .catch(() => showToast("Gagal menghapus siswa!", "error"));
  };

  return (
    <div className="min-h-screen bg-gray-100 p-6">

      {/* Toast */}
      {toast && (
        <div className={`fixed top-4 right-4 z-50 px-4 py-2 rounded-lg text-white text-sm font-medium shadow-lg ${toast.type === "success" ? "bg-green-600" : "bg-red-600"}`}>
          {toast.msg}
        </div>
      )}

      {/* Modal Edit */}
      {editSiswa && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40">
          <div className="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
            <h3 className="text-lg font-semibold mb-4">Edit Nama Siswa</h3>
            <input
              type="text"
              value={editNama}
              onChange={e => setEditNama(e.target.value)}
              className="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <div className="flex gap-2">
              <button
                onClick={() => setEditSiswa(null)}
                className="flex-1 py-2 rounded-lg border border-gray-300 text-sm text-gray-600 hover:bg-gray-50"
              >
                Batal
              </button>
              <button
                onClick={handleSaveEdit}
                className="flex-1 py-2 rounded-lg bg-blue-800 text-white text-sm font-medium hover:bg-blue-900"
              >
                Simpan
              </button>
            </div>
          </div>
        </div>
      )}

      <div className="max-w-2xl mx-auto">

        {/* Header */}
        <div className="bg-white rounded-2xl shadow-lg p-6 mb-4">
          <div className="flex items-center gap-3 mb-2">
            <div className="bg-blue-800 text-white rounded-lg px-3 py-1 text-sm font-bold">PKBM</div>
            <h1 className="text-xl font-bold text-gray-800">E-Rapor PKBM</h1>
          </div>
          <h2 className="text-lg font-semibold text-gray-700">Data Siswa — {namaKelas}</h2>
          <p className="text-sm text-gray-400">{siswaList.length} siswa terdaftar</p>
        </div>

        {/* Tabel */}
        <div className="bg-white rounded-2xl shadow-lg overflow-hidden">
          {loading ? (
            <div className="p-6 text-center text-gray-400">Memuat data...</div>
          ) : siswaList.length === 0 ? (
            <div className="p-6 text-center text-gray-400">Tidak ada siswa di kelas ini</div>
          ) : (
            <table className="w-full text-sm">
              <thead className="bg-blue-800 text-white">
                <tr>
                  <th className="px-4 py-3 text-left">No</th>
                  <th className="px-4 py-3 text-left">Nama Siswa</th>
                  <th className="px-4 py-3 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                {siswaList.map((siswa, index) => (
                  <tr key={siswa.id_siswa} className={index % 2 === 0 ? "bg-white" : "bg-gray-50"}>
                    <td className="px-4 py-3 text-gray-500">{index + 1}</td>
                    <td className="px-4 py-3 font-medium">{siswa.nama_siswa}</td>
                    <td className="px-4 py-3 text-center">
                      <div className="flex gap-2 justify-center">
                        <button
                          onClick={() => handleEdit(siswa)}
                          className="px-3 py-1 bg-yellow-400 text-white rounded-lg text-xs font-medium hover:bg-yellow-500"
                        >
                          Edit
                        </button>
                        <button
                          onClick={() => handleHapus(siswa.id_siswa, siswa.nama_siswa)}
                          className="px-3 py-1 bg-red-500 text-white rounded-lg text-xs font-medium hover:bg-red-600"
                        >
                          Hapus
                        </button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>

        <button
          onClick={() => navigate("/")}
          className="mt-4 w-full bg-gray-200 text-gray-700 py-2 rounded-lg text-sm font-medium hover:bg-gray-300 transition"
        >
          ← Kembali Pilih Kelas
        </button>

      </div>
    </div>
  );
}