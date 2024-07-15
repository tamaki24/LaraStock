import { Link } from '@inertiajs/react';
import { useState, useEffect } from 'react';

export const Item = ({ props }) => {
  const { id, itemName, categoryName, storage, place, stock, deadline } = props;
  const [deadlineColor, setDeadlineColor] = useState('text-gray-900');
  const [accentColor, setAccentColor] = useState('border-l-gray-400');

  useEffect(() => {
    const now = new Date();
    const oneWeek = new Date();
    oneWeek.setDate(now.getDate() + 7);
    const deadlineDate = new Date(deadline);

    if (now < deadlineDate && deadlineDate <= oneWeek) {
      // 一週間以内
      setDeadlineColor('text-blue-500');
      setAccentColor('border-l-blue-300');
    } else if (deadlineDate < now) {
      // 期限切れ
      setDeadlineColor('text-red-500');
      setAccentColor('border-l-red-300');
    }
  }, []);

  return (
    <div className={`py-2 border-l-8 ${accentColor} bg-gray-100 pl-3 mb-3 w-full mr-3`}>
      <div className="flex items-start pb-1 w-max">
        <p className="text-xl font-bold pr-3">{itemName}</p>
        <p className="mt-[2px] px-2 py-[2px] text-xs font-semibold text-center items-center">
          # {categoryName}
        </p>
      </div>
      <div className="w-max flex justify-between min-w-[800px]">
        <div className="text-start min-w-[360px] max-w-[400px]">
          <p>
            期限：<span className={`${deadlineColor} pr-3`}>{deadline}</span>
          </p>
          <p className="pr-3">陳列場所： {place}</p>
        </div>
        <div className="text-start min-w-[260px] max-w-[400px]">
          <p className="pr-3">在庫数：{stock}</p>
          <p className="pr-3">在庫場所： {storage}</p>
        </div>

        <Link href={`/stock/${id}`}>
          <button className="bg-cyan-500 hover:bg-cyan-700 text-white font-bold px-4 rounded mr-5 focus:outline-none focus:shadow-outline text-sm h-8">
            編集
          </button>
        </Link>
      </div>
    </div>
  );
};
