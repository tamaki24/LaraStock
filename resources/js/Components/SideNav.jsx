import { Link } from '@inertiajs/react';
import React from 'react';

export const SideNav = () => {
  return (
    <div className="py-12  h-[100%]">
      <div className="w-max ml-auto px-6">
        <div className="bg-white overflow-hidden shadow-sm rounded-lg">
          <div className="p-6 text-gray-900">Menu</div>

          <ul className="w-[300px] p-6">
            <Link href="/home" className="w-max">
              <li className="border-b border-b-gray-400 mb-10 text-lg">ホーム</li>
            </Link>
            <Link href="/stock" className="w-max">
              <li className="border-b border-b-gray-400 mb-3 text-lg">在庫一覧</li>
            </Link>
            <Link href="/stock/create" className="w-max">
              <li className="border-b border-b-gray-400 mb-10 text-lg">在庫登録</li>
            </Link>

            <Link href="/item" className="w-max">
              <li className="border-b border-b-gray-400 mb-3 text-lg">商品マスタ一覧</li>
            </Link>
            <Link href="/item/create" className="w-max">
              <li className="border-b border-b-gray-400 mb-10 text-lg">商品マスタ登録</li>
            </Link>

            <Link href="/category" className="w-max">
              <li className="border-b border-b-gray-400 mb-3 text-lg">カテゴリ一覧</li>
            </Link>
            <Link href="/category/create" className="w-max">
              <li className="border-b border-b-gray-400 mb-3 text-lg">カテゴリ登録</li>
            </Link>
          </ul>
        </div>
      </div>
    </div>
  );
};
