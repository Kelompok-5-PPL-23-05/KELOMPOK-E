import { useState, useEffect } from "react";
import axios from "axios";

export default function App() {
  const [kelasList, setKelasList] = useState([]);
  const [selectedKelas, setSelectedKelas] = useState("");

  useEffect(() => {
    axios.get("http://127.0.0.1:8000/api/kelas")
      .then(res => setKelasList(res.data))
      .catch(err => console.error(err));
  }, []);

  const handlePilihKelas = (e) => {
    setSelectedKelas(e.target.value);
    localStorage.setItem("selectedKelas", e.target.value);
  };

  return (
    <div>
      <h2>Pilih Kelas</h2>
      <select value={selectedKelas} onChange={handlePilihKelas}>
        <option value="">-- Pilih Kelas --</option>
        {kelasList.map(kelas => (
          <option key={kelas.id_kelas} value={kelas.id_kelas}>
            {kelas.nama_kelas}
          </option>
        ))}
      </select>

      {selectedKelas && (
        <p>Kelas dipilih: <strong>
          {kelasList.find(k => k.id_kelas == selectedKelas)?.nama_kelas}
        </strong></p>
      )}
    </div>
  );
}