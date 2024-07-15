import { InnerLayout } from '@/Layouts/InnerLayout';
import MainLayout from '@/Layouts/MainLayout';
import { useState, useEffect } from 'react';

const Create = ({ auth, categories }) => {
  const [selectedCategory, setSelectedCategory] = useState('');
  const [categoryDetail, setCategoryDetail] = useState({ category: '' });
  const [editItem, setEditItem] = useState({ name: '', category_id: '', place: '', remarks: '' });
  const [errorMessage, setErrorMessage] = useState('');
  const [successMessage, setSuccessMessage] = useState('');
  const [validationMessage, setValidationMessage] = useState('');

  useEffect(() => {}, []);

  const handleSubmit = (e) => {
    e.preventDefault();
    // データの更新処理
    setErrorMessage('');
    console.log(editItem);
    const bool = validation();
    if (bool) {
      axios
        .post(`/api/item`, editItem)
        .then((response) => {
          console.log('Item updated:', response.data);
          setSuccessMessage('登録が完了しました。 リダイレクトしています...');
          // リダイレクト
          setTimeout(() => {
            setSuccessMessage('');
            window.location.href = '/item';
          }, 2000);
        })
        .catch((e) => {
          console.error('Error updating item:', e);
          setErrorMessage('登録に失敗しました。');
        });
    }
  };

  const validation = () => {
    setValidationMessage('');
    let message = '';

    if (editItem.name === '') {
      message += '商品名が入力されていません。　';
    }

    if (editItem.category_id === '') {
      message += 'カテゴリーが選択されていません。　';
    }

    if (editItem.place === '') {
      message += '陳列場所が入力されていません。　';
    }

    if (message === '') {
      return true;
    }

    setValidationMessage(message);
    return false;
  };

  const handleDelete = () => {
    // 削除処理
    const confirmed = window.confirm('本当に削除しますか？');
    if (!confirmed) {
      return; // ユーザーがキャンセルした場合は何もしない
    }
    // deleteStock();
  };

  const deleteStock = async () => {
    await axios
      .delete(`/api/item`, { data: { stock_id: item.id } })
      .then((response) => {
        setSuccessMessage('削除が完了しました。 リダイレクトしています...');
        setTimeout(() => {
          setSuccessMessage('');
          window.location.href = '/item';
        }, 2000);
      })
      .catch((e) => {
        console.error('Error delete stock:', e);
        setErrorMessage('削除に失敗しました。');
      });
  };

  const handleChangeCategory = async (e) => {
    const categoryid = e.target.value;
    setSelectedCategory(categoryid);
    const category = categories.filter((c) => c.id == categoryid);
    setCategoryDetail({
      storage: category[0].storage,
    });
    editItem.category_id = categoryid;
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setEditItem({
      ...editItem,
      [name]: value,
    });
  };

  return (
    <MainLayout user={auth.user}>
      <InnerLayout title="在庫編集">
        <div className="max-w-md mx-auto mt-10">
          <form onSubmit={handleSubmit} className="bg-white  px-8 pt-6 pb-8 mb-4">
            <div className="mb-4">
              <label htmlFor="name" className="block text-gray-700 text-sm font-bold mb-2">
                商品名
              </label>
              <input
                type="text"
                name="name"
                value={editItem.name}
                onChange={handleChange}
                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              />
            </div>
            <div className="mb-4">
              <label
                htmlFor="category_id"
                className="block text-gray-700 text-sm font-bold mb-2 mr-2"
              >
                カテゴリー
              </label>
              <select
                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline "
                id="category_id"
                onChange={handleChangeCategory}
              >
                <option value="">選択してください</option>
                {categories?.map((c) => (
                  <option key={c.id} value={c.id}>
                    {c.name}
                  </option>
                ))}
              </select>
            </div>
            {selectedCategory !== '' && (
              <div className="flex justify-start mb-2 text-blue-600">
                <p className="pr-3 text-xs font-semibold text-center items-center">
                  # {categoryDetail.storage}
                </p>
              </div>
            )}
            <div className="mb-4">
              <label htmlFor="place" className="block text-gray-700 text-sm font-bold mb-2">
                陳列場所
              </label>
              <input
                type="text"
                name="place"
                value={editItem.place}
                onChange={handleChange}
                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              />
            </div>

            <div className="mb-4">
              <label htmlFor="remarks" className="block text-gray-700 text-sm font-bold mb-2">
                備考
              </label>
              <textarea
                name="remarks"
                value={editItem.remarks}
                onChange={handleChange}
                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
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
            {validationMessage !== '' && (
              <p className="my-2 text-xs text-red-400 break-words">{validationMessage}</p>
            )}

            {errorMessage !== '' && (
              <p className="my-2 text-xs text-red-400 break-words">{errorMessage}</p>
            )}

            {successMessage !== '' && (
              <p className="my-2 text-xs font-bold text-cyan-500 break-words">{successMessage}</p>
            )}
          </form>
        </div>
      </InnerLayout>
    </MainLayout>
  );
};

export default Create;
