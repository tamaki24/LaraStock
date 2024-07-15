import { ItemList } from '@/Components/Stock/ItemList';
import { InnerLayout } from '@/Layouts/InnerLayout';
import MainLayout from '@/Layouts/MainLayout';
import axios from 'axios';
import { useState, useEffect } from 'react';

const Index = ({ auth, stocks, categories, items }) => {
  const [selectedCategory, setSelectedCategory] = useState('');
  const [selectedItem, setSelectedItem] = useState('');
  const [renderStocks, setRenderStocks] = useState([]);

  useEffect(() => {
    setRenderStocks(stocks);
  }, []);

  useEffect(() => {
    fetchStocks();
  }, [selectedCategory, selectedItem]);

  const handleChangeCategory = async (e) => {
    setSelectedCategory(e.target.value);
  };

  const getParams = () => {
    const params = {};
    if (selectedCategory !== '' && selectedItem !== '') {
      params.category_id = selectedCategory;
      params.master_id = selectedItem;
    } else if (selectedCategory !== '') {
      params.category_id = selectedCategory;
    } else if (selectedItem !== '') {
      params.master_id = selectedItem;
    }
    return params;
  };

  const fetchStocks = async () => {
    try {
      const params = getParams();
      const response = await axios.get('/api/stock', {
        params,
      });
      setRenderStocks(response.data);
    } catch (e) {
      console.error(e);
    }
  };
  const handleChangeItems = async (e) => {
    setSelectedItem(e.target.value);
  };
  return (
    <MainLayout user={auth.user}>
      <InnerLayout title="在庫一覧">
        <div className="w-full text-center mt-5">
          <label htmlFor="categoryList" className="inline-block text-xs mr-1">
            カテゴリー：
          </label>
          <select
            className="h-8 text-xs border-0 border-b border-cyan-300"
            id="categoryList"
            onChange={handleChangeCategory}
          >
            <option value="">全て</option>
            {categories?.map((item) => (
              <option key={item.id} value={item.id}>
                {item.name}
              </option>
            ))}
          </select>
          <label htmlFor="itemList" className="inline-block text-xs mr-1">
            商品：
          </label>
          <select
            className="h-8 text-xs border-0 border-b border-cyan-300"
            id="itemList"
            onChange={handleChangeItems}
          >
            <option value="">全て</option>
            {items?.map((item) => (
              <option key={item.id} value={item.id}>
                {item.name}
              </option>
            ))}
          </select>
        </div>
        <ItemList stocks={renderStocks} />
      </InnerLayout>
    </MainLayout>
  );
};

export default Index;
