import { useState, useEffect } from 'react';
import axios from 'axios';
import MainLayout from '@/Layouts/MainLayout';
import { InnerLayout } from '@/Layouts/InnerLayout';
import { ItemList } from '@/Components/Stock/ItemList';

const Edit = ({ auth, stock, other_stocks }) => {
  const [stockData, setStockData] = useState(0);
  const [deadline, setDeadline] = useState('');
  const [errorMessage, setErrorMessage] = useState('');
  const [successMessage, setSuccessMessage] = useState('');

  useEffect(() => {
    setStockData(stock.stock);
    setDeadline(stock.deadline);
  }, []);

  const handleSubmit = (e) => {
    e.preventDefault();
    // データの更新処理
    setErrorMessage('');
    axios
      .patch(`/api/stock`, {
        stock_id: stock.id,
        stock: stockData,
        deadline: deadline,
      })
      .then((response) => {
        console.log('Stock updated:', response.data);
        setSuccessMessage('更新が完了しました。 リダイレクトしています...');
        // リダイレクト
        setTimeout(() => {
          setSuccessMessage('');
          window.location.href = '/stock';
        }, 2000);
      })
      .catch((e) => {
        console.error('Error updating stock:', e);
        setErrorMessage('更新に失敗しました。');
      });
  };
  const handleDelete = () => {
    // 削除処理
    const confirmed = window.confirm('本当に削除しますか？');
    if (!confirmed) {
      return; // ユーザーがキャンセルした場合は何もしない
    }
    deleteStock();
  };

  const deleteStock = async () => {
    await axios
      .delete(`/api/stock`, { data: { stock_id: stock.id } })
      .then((response) => {
        setSuccessMessage('削除が完了しました。 リダイレクトしています...');
        setTimeout(() => {
          setSuccessMessage('');
          window.location.href = '/stock';
        }, 2000);
      })
      .catch((e) => {
        console.error('Error delete stock:', e);
        setErrorMessage('削除に失敗しました。');
      });
  };

  return (
    <MainLayout user={auth.user}>
      <InnerLayout title="在庫編集">
        <div className="max-w-md mx-auto mt-10">
          <form onSubmit={handleSubmit} className="bg-white  px-8 pt-6 pb-8 mb-4">
            <div className="mb-4">
              <label className="block text-gray-700 text-sm font-bold mb-2">商品名</label>
              <p className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                {stock.itemName}
              </p>
            </div>
            <div className="mb-4">
              <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="stock">
                Stock
              </label>
              <input
                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="stock"
                name="stock"
                type="number"
                value={stockData}
                onChange={(e) => setStockData(e.target.value)}
              />
            </div>
            <div className="mb-6">
              <label className="block text-gray-700 text-sm font-bold mb-2">Deadline</label>
              <input
                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="deadline"
                type="date"
                placeholder="消費期限"
                value={deadline}
                onChange={(e) => setDeadline(e.target.value)}
              />
            </div>
            <div className="flex items-center justify-between">
              <button
                className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit"
              >
                Save
              </button>
              <button
                className="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="button"
                onClick={handleDelete}
              >
                delete
              </button>
            </div>

            {errorMessage !== '' && (
              <p className="my-2 text-xs text-red-400 break-words">{errorMessage}</p>
            )}

            {successMessage !== '' && (
              <p className="my-2 text-xs font-bold text-cyan-500 break-words">{successMessage}</p>
            )}
          </form>
        </div>
        {other_stocks.length > 0 && (
          <>
            <h3 className="text-2xl font-bold mt-5 text-center">同じ商品の在庫</h3>
            <ItemList stocks={other_stocks} />
          </>
        )}
      </InnerLayout>
    </MainLayout>
  );
};

export default Edit;
