import { InnerLayout } from '@/Layouts/InnerLayout';
import MainLayout from '@/Layouts/MainLayout';
import { useState } from 'react';

const Create = ({ auth, items }) => {
  const [selectedItem, setSelectedItem] = useState('');
  const [itemDetail, setItemDetail] = useState({ category: '', place: '', storage: '' });
  const [stock, setStock] = useState('');
  const [deadline, setDeadline] = useState('');
  const [validationMessage, setValidationMessage] = useState('');
  const [errorMessage, setErrorMessage] = useState('');
  const [successMessage, setSuccessMessage] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    setErrorMessage('');
    const bool = validation(selectedItem, stock, deadline);
    // フォームの送信処理を記述する
    if (bool) {
      axios
        .post(`/api/stock`, {
          master_id: selectedItem,
          stock: stock,
          deadline: deadline,
        })
        .then((response) => {
          console.log('Stock created');
          setSuccessMessage('登録が完了しました。 リダイレクトしています...');
          // リダイレクト
          setTimeout(() => {
            setSuccessMessage('');
            window.location.href = '/stock';
          }, 2000);
        })
        .catch((error) => {
          console.error('Error create stock:', error);
          setErrorMessage('登録に失敗しました。');
        });
    }
  };

  const validation = (selectedItem, stock, deadline) => {
    setValidationMessage('');
    let message = '';

    if (selectedItem === '') {
      message += '商品が選択されていません。　';
    }

    if (stock === '' || stock === '0') {
      message += '在庫が入力されていません。　';
    }

    if (deadline === '') {
      message += '消費期限が入力されていません。　';
    }

    if (message === '') {
      return true;
    }

    setValidationMessage(message);

    return false;
  };

  const handleChangeItems = async (e) => {
    const itemId = e.target.value;
    setSelectedItem(itemId);
    const item = items.filter((item) => item.id == itemId);
    setItemDetail({
      category: item[0].category.name,
      place: item[0].place,
      storage: item[0].category.storage,
    });
  };

  return (
    <MainLayout user={auth.user}>
      <InnerLayout title="在庫登録">
        <div className="max-w-md mx-auto mt-10">
          <form onSubmit={handleSubmit} className="bg-white px-8 pt-6 pb-8 mb-4">
            <div className="mb-4">
              <label htmlFor="itemList" className="block text-gray-700 text-sm font-bold mb-2 mr-2">
                商品：
              </label>
              <select
                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline "
                id="itemList"
                onChange={handleChangeItems}
              >
                <option value="">選択してください</option>
                {items.map((item) => (
                  <option key={item.id} value={item.id}>
                    {item.name}
                  </option>
                ))}
              </select>
            </div>
            {selectedItem !== '' && (
              <div className="flex justify-start mb-2 text-blue-600">
                <p className="pr-3 text-xs font-semibold text-center items-center">
                  # {itemDetail.category}
                </p>
                <p className="pr-3 text-xs font-semibold text-center items-center">
                  # {itemDetail.storage}
                </p>
                <p className="text-xs font-semibold text-center items-center">
                  # {itemDetail.place}
                </p>
              </div>
            )}

            <div className="mb-4">
              <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="stock">
                在庫数
              </label>
              <input
                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="stock"
                type="number"
                placeholder="0"
                value={stock}
                onChange={(e) => setStock(e.target.value)}
              />
            </div>
            <div className="mb-6">
              <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="deadline">
                消費期限
              </label>
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
                className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-3 focus:outline-none focus:shadow-outline"
                type="submit"
              >
                Save
              </button>
              {validationMessage !== '' && (
                <p className="text-xs text-red-400 break-words">{validationMessage}</p>
              )}
            </div>
          </form>
          {errorMessage !== '' && (
            <p className="my-2 text-xs text-red-400 break-words">{errorMessage}</p>
          )}

          {successMessage !== '' && (
            <p className="my-2 text-xs font-bold text-cyan-500 break-words">{successMessage}</p>
          )}
        </div>
      </InnerLayout>
    </MainLayout>
  );
};
export default Create;
