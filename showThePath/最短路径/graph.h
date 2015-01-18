#ifndef _GRAPHMTX_LJK
#define _GRAPHMTX_LJK
#include<iostream>
#include <stack>
using namespace std;
const int Defaultvertices=100;
const double maxWeight=100000000000.0;
template<class T,class E>
class Graphmtx{
public:

	Graphmtx(int sz=Defaultvertices);
	~Graphmtx(){delete[] VerticesList;delete[] Edge;}
	T getvalue(int i){
		return (i>=0&&i<=numVertices)?VerticesList[i]:NULL;
	}
	E getWeight(int v1,int v2){
		return (v1!=-1&&v2!=-1)?Edge[v1][v2]:0;
	}
	int getFirstNeighbor(int v);
	int getNextNeighbor(int v,int w);
	bool insertVertex(const T& vertex);
	bool insertEdge(int v1,int v2, E cost);
	bool removeVertex(int v);
	bool removeEdge(int v1,int v2);
	int NumberOfVertices(){return numVertices;}
	int NumberOfEdges(){return numEdges;}
	void DFS(const T& begin);
	void DFS(int v,bool visited[]);
	void DFS_V1(int v,bool visited[]);
friend istream& operator>>(istream& in,  Graphmtx<T,E>& G);    //����
friend ostream& operator<<(ostream& out, Graphmtx<T,E>& G);    //���
private:
	int maxVertices;                              //��󶥵���
	int numEdges;                                 //��ǰ������
	int numVertices;                              //��ǰ������
	T *VerticesList;                              //�����
	E **Edge;                                     //�ڽӾ���

	int getVertexPos(T vertex)
	{                                             //����������ͼ�е�λ��
		for(int i=0;i<numVertices;i++)
			if(VerticesList[i]==vertex)return i;
		return -1;
	}

};
template<class T,class E>
Graphmtx<T,E>::Graphmtx(int sz){
	maxVertices=sz;
	numVertices=0;
	numEdges=0;
	int i,j;
	VerticesList=new T[maxVertices];
	Edge=new E*[maxVertices];
	for( i=0;i<maxVertices;i++)                         //�������������
	Edge[i]=new E[maxVertices];                         //�����ڽӾ�������
	for(i=0;i<maxVertices;i++){                         //�ڽӾ����ʼ��
		for(j=0;j<maxVertices;j++)
			if(i==j)Edge[i][j]=0;
			else Edge[i][j]=maxWeight;
	}
}
/*
 * @description����������λ��Ϊv �ĵ�һ���ڽӶ����λ�ã�����Ҳ�������������-1
 * @return��
 */
template<class T,class E>
int Graphmtx<T,E>::getFirstNeighbor(int v){
	if(v!=-1){
		for(int col=0;col<numVertices;col++){
			if(Edge[v][col]>0&&Edge[v][col]<maxWeight) return col;
		}
	}
	return -1;
}
/*
 * @description����������v ��ĳ�ڽӶ���w����һ���ڽӶ���λ��
 */
template<class T,class E>
int Graphmtx<T,E>::getNextNeighbor(int v,int w){
	int col;
	if(v!=-1&&w!=-1){
		for(col=w+1;col<numVertices;col++)
			if((Edge[v][col]>0)&&(Edge[v][col]<maxWeight)) return col;
	}
	return -1;
}
/*
 * @description��
 */
template<class T,class E>
bool Graphmtx<T,E>::insertVertex(const T& vertex){
	if(numVertices==maxVertices)return false;
	VerticesList[numVertices++]=vertex;
	return true;
}
template<class T,class E>
bool Graphmtx<T,E>::removeVertex(int v)
{
    if(v<0||v>=numVertices) return false;
    if(numVertices==1) return false; //ֻʣ��һ�������ʱ����ɾ��
    int i,j;
    VerticesList[v]=VerticesList[numVertices-1];  //���һ������ȡ����ɾ������
    for(i=0;i<numVertices;i++)
        if(Edge[i][v]>0&&Edge[i][v]<maxWeight) numEdges--;
    for(i=0;i<numVertices;i++)
        Edge[i][v]=Edge[i][numVertices-1];
    numVertices--;
    for(j=0;j<numVertices;j++)
        Edge[v][j]=Edge[numVertices-1][j];
    return true;
}
template<class T,class E>
bool Graphmtx<T,E>::removeEdge(int v1,int v2)
{
    if(v1>-1&&v1<numVertices&&v2>-1&&v2<numVertices&&Edge[v1][v2]>0&&Edge[v1][v2]<maxWeight)
    {
        Edge[v1][v2]=maxWeight;
        numEdges--;
        return true;
    }
    return false;
}


/*
 * @description��
 */
template<class T,class E>
bool Graphmtx<T,E>::insertEdge(int v1, int v2, E cost){
	if(v1>-1&&v1<numVertices&&v2>-1&&v2<numVertices&&Edge[v1][v2]==maxWeight)
	{
		Edge[v1][v2]=cost;
		numEdges++;
		return true;
	}
	else return false;
}
template<class T,class E>
istream& operator>>(istream& in,Graphmtx<T,E>& G)
{
    int i,j,k,n,m;
    T e1,e2;
    E weight;
    in>>n>>m;   //���붥�����ͱ���
    for(i=0;i<n;i++)
    {
        in>>e1;
        G.insertVertex(e1);
    }
    i=0;
    while(i<m)
    {
        in>>e1>>e2>>weight;
        j=G.getVertexPos(e1);
        k=G.getVertexPos(e2);
        if(j==-1||k==-1)
           cout<<"�����˶������������������롣"<<endl;
        else
        {
            G.insertEdge(j,k,weight);
            i++;
        }
    }
    return in;
}
template<class T,class E>
ostream& operator<<(ostream& out,Graphmtx<T,E>& G)
{
    int i,j,n,m;
    T e1,e2;
    E w;
    n=G.NumberOfVertices();
    m=G.NumberOfEdges();
    out<<"����������"<<n<<" ��������"<<m<<endl;
    for(i=0;i<n;i++)
    for(j=0;j<n;j++){
       w=G.getWeight(i,j);
       if(w>0&&w<maxWeight)
       {
           e1=G.getValue(i);
           e2=G.getValue(j);
           out<<"("<<e1<<","<<e2<<","<<w<<")"<<endl;
       }
    }
    return out;
}
/*
 * @description��
 */
template<class T,class E>
void Graphmtx<T,E>::DFS(const T& begin){
	int i,loc;
	bool *visited=new bool[numVertices];
	for(i=0;i<numVertices;i++)
		visited[i]=false;
	loc=getVertexPos(begin);
	//cout<<getvalue(begin);
	DFS_V1(loc,visited);
}
/*
 * @description��
 */
template<class T,class E>
void Graphmtx<T,E>::DFS(int v,bool visited[]){
	visited[v]=true;
	int w=getFirstNeighbor(v);
	while(w!=-1){
		if(visited[w]==false){
		    cout<<"->"<<getvalue(w)<<"("<<Edge[v][w]<<")";
			DFS(w,visited);
		}
		w=getNextNeighbor(v,w);
	}
}


//�ǵݹ�ʵ�ִ�ͼ��ĳ���������������ȱ���
template<class T,class E>
void Graphmtx<T,E>::DFS_V1(int v,bool visited[])
{
    stack<int> s;
    s.push(v);
    while (!s.empty())
   {
       int w = s.top(); s.pop();
       if (visited[w]==false)
       {
          cout<<" "<<getvalue(w);
		  visited[w] = true;
	      int ww=getFirstNeighbor(w);
	      while(ww!=-1){
		  if(visited[ww]==false)
		  s.push(ww);
		  ww=getNextNeighbor(w,ww);
	    }
       }
	}
}
#endif
