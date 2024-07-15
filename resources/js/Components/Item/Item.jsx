import { Link } from '@inertiajs/react';

export const Item = ({ props }) => {
  const { id, name, category, place } = props;

  return (
    <div className={`py-2 border-l-8 bg-gray-100 pl-3 mb-3 w-full mr-3`}>
      <div className="flex items-start pb-1 w-max">
        <p className="text-xl font-bold pr-3">{name}</p>
        <p className="mt-[2px] px-2 py-[2px] text-xs font-semibold text-center items-center">
          # {category.name}
        </p>
      </div>
      <div className="w-max flex justify-between min-w-[800px]">
        <div className="text-start min-w-[360px] max-w-[400px]">
          <p className="pr-3">陳列場所： {place}</p>
        </div>
        <div className="text-start min-w-[260px] max-w-[400px]">
          <p className="pr-3">在庫場所： {category.storage}</p>
        </div>

        <Link href={`/item/${id}`}>
          <button className="bg-cyan-500 hover:bg-cyan-700 text-white font-bold px-4 rounded mr-5 focus:outline-none focus:shadow-outline text-sm h-8">
            編集
          </button>
        </Link>
      </div>
    </div>
  );
};
